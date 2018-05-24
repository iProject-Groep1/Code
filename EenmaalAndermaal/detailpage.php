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


<div class="uk-grid uk-flex uk-flex-wrap uk-padding-resize">
<div class="uk-width-1-2@xl uk-width-1-1@l uk-width-1-1@m uk-width-1-1@s ">
    <div class="uk-display-inline uk-flex-wrap uk-flex-first uk-cover-container uk-margin-small-left uk-margin-small-right">
        <img class="uk-flex-center uk-align-center uk-height" src="' . $image . '"
                     style="background-image: url(' . $image . ');" alt="Image">

    </div>
    </div>
    <div class="uk-grid-medium uk-width-1-2@xl uk-width-1-1 uk-flex-wrap uk-flex-last uk-margin-remove-left">
        <div class="uk-card-header niagara">
            <div class="uk-grid-small uk-flex-middle">
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
            <div class="uk-width-1-4 uk-align-left uk-margin-remove-right uk-padding-remove-left">
                <form action="scripts/placeBidDirect.php" method="get">
                    <input class="uk-input" type="text" name="id" value="' . $id . '"hidden>
                    <input class="uk-input " type="number" placeholder="€' . $minBid . '" name="bedrag">
            </div>
            <input class="uk-button uk-button-danger uk-align-left uk-margin-remove-right" type="submit" name="submit" value="Bied direct">
            </form>
            <a href="scripts/placeBid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-right niagara">Bied minimum</a>
            <div class="uk-width-1-4 uk-align-right">
                <input class="uk-input uk-width-1-8" type="text" value= "€' . $minBid . '" disabled>
            </div>
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
