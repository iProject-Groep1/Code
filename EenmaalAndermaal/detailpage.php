<?php
ob_start();
$pageTitle = 'Veiling detailpagina';
require_once('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/detailpagina-functions.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');

if (isset($_SESSION['overBidMelding']) && !empty($_SESSION['overBidMelding'])) {
    echo $_SESSION['overBidMelding'];
    $_SESSION['overBidMelding'] = "";
}

$idCorrect = false;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        $stmt = $dbh->prepare("SELECT COUNT(voorwerpnummer) AS aantal FROM voorwerp WHERE voorwerpnummer = :voorwerpnummer");
        $stmt->bindValue(":voorwerpnummer", $_GET['id'], PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            if ($row['aantal'] == 0) {
                $idCorrect = false;
            } else {
                $idCorrect = true;
            }
        }
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
    }
} else {

    header('Location: errorpage.php?err=404');
}

if ($idCorrect) {
    if (isset($_SESSION['bodMelding']) && !empty($_SESSION['bodMelding'])) {
        echo $_SESSION['bodMelding'];
        $_SESSION['bodMelding'] = "";
    }
    $id = $_GET['id'];
    placeItem($dbh, $id);


} else {

    header('Location: errorpage.php?err=404');
}


function placeItem($dbh, $id)
{
//TODO een query gebruiken voor al deze losse dingen
    $timeOfEnding = getAuctionEnd($dbh, $id);
    $minBid = calcMinBid($dbh, $id);
    $image = getAuctionFilename($dbh, $id);
    $productTitle = '';
    $seller = "";
    $sellerMail = "";
    $buyer = "";
    $buyerMail = "";
    $categoryArray;

    $imageScript = '';

    try {
        $stmt = $dbh->prepare("SELECT	titel, koper, gK.mail_adres AS koperMail, gV.mail_adres AS verkoperMail, v.verkoper,
		P4.rubrieknaam AS Parent4Rubrieknaam,
		P4.rubrieknummer AS Parent4Rubrieknummer,
		P3.rubrieknaam AS Parent3Rubrieknaam,
		P3.rubrieknummer AS Parent3Rubrieknummer,
		P2.rubrieknaam AS Parent2Rubrieknaam,
		P2.rubrieknummer AS Parent2Rubrieknummer,
		P1.rubrieknaam AS Parent1Rubrieknaam,
		P1.rubrieknummer AS Parent1Rubrieknummer,
		S.rubrieknaam AS HuidigRubrieknaam, 
		S.rubrieknummer AS HuidigRubrieknummer		
FROM	Voorwerp v 
		LEFT JOIN Gebruiker gV on  v.verkoper = gV.gebruikersnaam
		LEFT JOIN Gebruiker gK on v.koper = gK.gebruikersnaam
		LEFT JOIN	VoorwerpInRubriek vir ON v.voorwerpnummer = vir.voorwerp 
		LEFT JOIN rubriek S ON rubriek_op_laagste_niveau = rubrieknummer 
		LEFT JOIN rubriek P1 ON P1.rubrieknummer = S.parent
		LEFT JOIN rubriek P2 ON P2.rubrieknummer = P1.parent
		LEFT JOIN rubriek P3 ON P3.rubrieknummer = P2.parent
		LEFT JOIN rubriek P4 ON P4.rubrieknummer = P3.parent
WHERE voorwerpnummer = :voorwerpnummer");
        $stmt->bindValue(":voorwerpnummer", $id, PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch()) { //loopt elke row van de resultaten door
            $productTitle = $row['titel'];
            $categoryArray[$row['Parent4Rubrieknaam']] = $row['Parent4Rubrieknummer'];
            $categoryArray[$row['Parent3Rubrieknaam']] = $row['Parent3Rubrieknummer'];
            $categoryArray[$row['Parent2Rubrieknaam']] = $row['Parent2Rubrieknummer'];
            $categoryArray[$row['Parent1Rubrieknaam']] = $row['Parent1Rubrieknummer'];
            $categoryArray[$row['HuidigRubrieknaam']] = $row['HuidigRubrieknummer'];
            $seller = $row['verkoper'];
            $sellerMail = $row['verkoperMail'];
            $buyer = $row['koper'];
            $buyerMail =  $row['koperMail'];
        }
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }

//breadcrumb
    echo '
<div class="uk-margin-detail">
<ul class="uk-breadcrumb uk-width-1-1" >
    <li><a href="index.php">Home</a></li>';
    //loopt door de bovenstaande rubrieken en vult de breadcrumb
    foreach ($categoryArray as $categoryName => $categoryID) {
        if (!empty($categoryID && $categoryID != -1)) {
            echo '<li><a href="category.php?categoryID=' . $categoryID . '">' . $categoryName . '</a></li>';
        }
    }
    echo '<li class="uk-disabled"><span>' . $productTitle . '</span></li>
</ul>
</div>
';
    echo '<h1 class="marge-left">' . $productTitle . '</h1>';

    echo '


<div class="uk-grid uk-flex uk-flex-wrap uk-padding-resize">
<div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">

    <div class="uk-display-inline uk-flex-wrap uk-flex-first uk-cover-container uk-margin-small-left uk-margin-small-right">
    <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider="center: true">
    <ul class="uk-slider-items uk-grid uk-grid-match" uk-height-viewport="offset-top: true; offset-bottom: 30">
        ';

    foreach ($image as $key) {
        $imageScript .= '<li class="uk-width-3-4 " >
        <img class="uk-flex-center uk-align-center uk-height" src="' . $key . '"
                     style="background-image: url(' . $key . ');" alt="' . $key . '" >
                     </li >';
    }
    echo $imageScript;


    echo '
    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-maak-rood" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-maak-rood" href="#" uk-slidenav-next uk-slider-item="next"></a>

                     </div >
                   

    </div >
    </div >
    <div class="uk-grid-medium uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s uk-flex-wrap uk-flex-last uk-margin-remove-left" >
        <div class="uk-card-header niagara" >
            
            ';
    $auctionStatus = getAuctionStatus($dbh);
    if ($auctionStatus == 1) {
        echo '<h4 class="uk-text-center uk-align-center white-font"> Deze veiling is gesloten </h4>';
        if(isset($_SESSION['username'])) {
            if ($_SESSION['username'] == $seller) {
                echo '<h4 class="uk-text-center uk-align-center white-font">Neem contact op met de winnaar <a href="mailto:' . $buyerMail . '?Subject=U%20heeft%20gewonnen" target="_top" uk-icon="icon: mail" uk-tooltip="Mail ' . $buyer . '"></a></h4>';
            }
            if ($_SESSION['username'] == $buyer) {
                echo '<h4 class="uk-text-center uk-align-center white-font">Neem contact op met de verkoper <a href="mailto:' . $sellerMail . '?Subject=Ik%20heb%20gewonnen" target="_top" uk-icon="icon: mail" uk-tooltip="Mail  ' . $seller . '"></a></h4>';
            }
        }
    } else if ($auctionStatus == 0) {
        echo '
            
            <div class="uk-grid-small uk-flex-middle" >
                <div class="uk-text-center uk-align-center" >
                    <div class=" uk-display-inline-block uk-align-center" >     
                        <div class="uk-grid-small  uk-child-width-auto white-font" uk-grid uk-countdown = "date: ' . $timeOfEnding . ' " >
                            <div >
                                <div class="uk-countdown-number uk-countdown-days uk-text-center" ></div >
                            </div >
                            <div class="uk-countdown-separator" >:</div >
                            <div >
                                <div class="uk-countdown-number uk-countdown-hours uk-text-center" ></div >
                            </div >
                            <div class="uk-countdown-separator" >:</div >
                            <div >
                                <div class="uk-countdown-number uk-countdown-minutes uk-text-center" ></div >
                            </div >
                            <div class="uk-countdown-separator" >:</div >
                            <div >
                            <div class="uk-countdown-number uk-countdown-seconds uk-text-center" ></div >
                            </div >
                        </div >
                    </div >
                </div >
            </div >
            ';
    }
    echo '
        </div >
        <div class="uk-card-body grey" >
';
    if ($auctionStatus == 1) {
        echo '<h3> Veiling winnaar: </h3>';
        echo getBids($dbh, 1);
    } else {
        echo getBids($dbh);

        echo '
        </div >
        <div class="uk-card-footer grey" >
            <div class="uk-width-1-4 uk-align-left uk-margin-remove-right uk-padding-remove-left" >
                <form action = "scripts/place-bid-direct.php" method = "get" >
                    <input class="uk-input" type = "text" name = "id" value = "' . $id . '"hidden >
                    <input class="uk-input " type = "number" min="' . $minBid . '" step="0.01" placeholder = "€' . $minBid . '" name = "bedrag" >
            </div >
            <input class="uk-button uk-button-danger uk-align-left uk-margin-remove-right" type = "submit" name = "submit" value = "Bied direct" >
            </form >
            <a href = "scripts/place-bid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-right niagara" > Bied minimum </a >
            <div class="uk-width-1-4 uk-align-right" >
                <input class="uk-input uk-width-1-8" type = "text" value = "€' . $minBid . '" disabled >
            </div >
            ';
    }
    echo '
        </div >
         
    </div >
</div >
<div class="uk-card auctions-reset-margin uk-card-default uk-card-body kleur-licht-blauw" >
    <h3 class="uk-display-block uk-align-center uk-text-center" > Product Informatie </h3 >
   


    <div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin" >
';
    echo getProductInfo($dbh);
    echo '


    </div >
    </div >

<div class="uk-card auctions-reset-margin uk-card-default uk-card-body" >
    <h3 class="uk-display-block uk-align-center uk-text-center" > Vergelijkbare veilingen </h3 >
    <p >
<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin" >
';

    getRelevantItems($dbh, $id);

    echo '
    </div >
    </p ></div >
';


}

require_once('scripts/footer.php');
?>
