<?php
require_once('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/detailpagina-functions.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');
require_once('scripts/product-info-function.php');

placeItem($dbh, 3);

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

<div class="uk-grid uk-padding-resize" data-uk-grid-margin="">

    <div class="uk-width-1-2 uk-row-first uk-display-inline uk-cover-container">
        <img class="uk-margin-detail " 
             src="images/productImages/' . $image . '"
             alt="" uk-cover>
    </div>

    <div class="uk-card uk-card-default uk-width-1-2@m uk-margin-detail-right">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-text-center uk-align-center">
                    <div class=" uk-display-inline-block uk-align-center">
                    <div class="uk-grid-small  uk-child-width-auto" uk-grid uk-countdown="date: ' . $timeOfEnding . ' ">
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
        <div class="uk-card-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
        </div>
        <div class="uk-card-footer">
         <div class="uk-width-1-4@s uk-align-left">
        <input class="uk-input" type="text" placeholder="€">
    </div>
            <div class="uk-width-1-4@s uk-align-right">
        <input class="uk-input" type="text" value= "€'. $minBid .'" disabled>
    </div><br>
            <a href="scripts/placeBid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-left" >Bied direct</a>
            <a href="scripts/placeBid.php?id=' . $id . '" class="uk-button uk-button-danger uk-align-right">Bied minimum</a>
        </div>
    </div>

</div>

<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
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
