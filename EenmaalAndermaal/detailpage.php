<?php
$pageTitle = 'Veiling detailpagina';
require_once('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/detailpagina-functions.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');


$id = $_GET['id'];
placeItem($dbh, $id);

<<<<<<< HEAD
if (isset($_SESSION['bodMelding']) && !empty($_SESSION['bodMelding'])) {
    echo $_SESSION['bodMelding'];
    $_SESSION['bodMelding'] = "";
=======
>>>>>>> 8464f387f8a2aaadd14de0c14113e79f1b10480b
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
<<<<<<< HEAD
<div class="uk-grid">
    <div class="uk-grid-medium uk-width-1-2 uk-row-first uk-display-inline uk-cover-container">
        <img class="uk-nice-uitlijnen" 
=======
<div class="uk-grid uk-padding-resize  marge-left" data-uk-grid-margin="">

    <div class="uk-width-1-2 uk-row-first uk-display-inline uk-cover-container">
        <img class="uk-margin-detail uk-nice-uitlijnen " 
>>>>>>> 8464f387f8a2aaadd14de0c14113e79f1b10480b
             src="images/productImages/' . $image . '"
             alt="" uk-cover>
    </div>

    <div class="uk-grid-medium uk-width-1-2 uk-grid-width-*">
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
         <div class="uk-width-1-4@s uk-align-left uk-margin-remove-right">
         <form action="scripts/placeBidDirect.php" method="get">
         <input class="uk-input" type="text" name="id" value="' . $id . '"hidden>
        <input class="uk-input " type="number" placeholder="€' . $minBid . '" name="bedrag">
<<<<<<< HEAD
        </div>
        <input class="uk-button uk-button-danger uk-align-left uk-margin-remove-right" type="submit" name="submit" value="Bied direct">
=======
        <input class="uk-button uk-button-danger uk-align-left" type="submit" name="submit" value="Bied direct">
>>>>>>> 8464f387f8a2aaadd14de0c14113e79f1b10480b
        </form>
        <a href="scripts/placeBid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-right niagara">Bied minimum</a>
        <div class="uk-width-1-4@s uk-align-right">
        <input class="uk-input" type="text" value= "€' . $minBid . '" disabled>
    </div>
<<<<<<< HEAD
            
=======
            <div class="uk-width-1-4@s uk-align-right">
        <input class="uk-input" type="text" value= "€' . $minBid . '" disabled>
    </div><br>
            <a href="scripts/placeBid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-right niagara">Bied minimum</a>
>>>>>>> 8464f387f8a2aaadd14de0c14113e79f1b10480b
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
