<?php
$pageTitle = 'Veiling detailpagina';
require_once('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/detailpagina-functions.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');

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
    die();
    header('Location: errorpage.php?err=404');
}

if ($idCorrect) {
    $id = $_GET['id'];
    placeItem($dbh, $id);

    if (isset($_SESSION['bodMelding']) && !empty($_SESSION['bodMelding'])) {
        echo $_SESSION['bodMelding'];
        $_SESSION['bodMelding'] = "";
    }
} else {
    header('Location: errorpage.php?err=404');
}


function placeItem($dbh, $id)
{
// TODO: ID moet worden aangepast aan het item.
    $timeOfEnding = getAuctionEnd($dbh, $id);
    $minBid = calcMinBid($dbh, $id);
    $image = getAuctionFilename($dbh, $id);

    echo '
<div class="uk-margin-detail">

<ul class="uk-breadcrumb" >
    <li><a href="#">Item</a></li>
    <li><a href="#">Item</a></li>
    <li class="uk-disabled"><a>Disabled</a></li>
    <li><span>Active</span></li>
</ul>
</div>
';
    echo getProductTitle($dbh);
    echo '
<div class="uk-grid uk-padding-resize  marge-left" data-uk-grid-margin="">

    <div class="uk-width-1-2 uk-row-first uk-display-inline uk-cover-container">
        <img class="uk-margin-detail uk-nice-uitlijnen " 
             src="images/productImages/' . $image . '"
             alt="" uk-cover>
    </div>

    <div class="uk-card uk-card-default uk-width-1-2@m uk-margin-detail-right no-shadow">
        <div class="uk-card-header niagara">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-text-center uk-align-center">
                    <div class=" uk-display-inline-block uk-align-center">     
                    <div class="uk-grid-small  uk-child-width-auto detail-pagina-countdown" uk-grid uk-countdown="date: ' . $timeOfEnding . ' ">
                        <div>
                            <div class="uk-countdown-number uk-countdown-days uk-text-center"></div>
                        </div>
                        <div class="uk-countdown-separator">:</div>
                        <div>
                            <div class="uk-countdown-number uk-countdown-hours uk-text-center"></div>
                        </div>
                        <div class="uk-countdown-separator">:</div>
                        <div>
                            <div class="uk-countdown-number uk-countdown-minutes uk-text-center"></div>
                        </div>
                        <div class="uk-countdown-separator">:</div>
                        <div>
                            <div class="uk-countdown-number uk-countdown-seconds uk-text-center"></div>
                        </div>
                    </div>
    
                </div>
                </div>
            </div>
        </div>
        <div class="uk-card-body scroll grey">
            ';
    echo getBids($dbh);
    echo '
        </div>
        <div class="uk-card-footer grey">
         <div class="uk-width-1-4@s uk-align-left">
         <form action="scripts/placeBidDirect.php" method="get">
         <input class="uk-input" type="text" name="id" value="' . $id . '"hidden>
        <input class="uk-input " type="number" placeholder="€' . $minBid . '" name="bedrag">
        <input class="uk-button uk-button-danger uk-align-left" type="submit" name="submit" value="Bied direct">
        </form>
    </div>
            <div class="uk-width-1-4@s uk-align-right">
        <input class="uk-input" type="text" value= "€' . $minBid . '" disabled>
    </div><br>
            <a href="scripts/placeBid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-right niagara">Bied minimum</a>
        </div>
    </div>

</div>

<div class="uk-card auctions-reset-margin uk-card-default uk-card-body kleur-licht-blauw">
    <h3 class="uk-display-block uk-align-center uk-text-center">Product Informatie</h3>
    <p>


    <div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">
        ';
    echo getProductInfo($dbh);

    echo '


    </div>
    </p></div>

<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
    <h3 class="uk-display-block uk-align-center uk-text-center">Vergelijkbare veilingen</h3>
    <p>
<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">
';

    getRelevantItems($dbh, $id);

    echo '
    </div>
    </p></div>
';


}

require_once('scripts/footer.php');
?>
