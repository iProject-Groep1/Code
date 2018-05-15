<?php
require_once('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/detailpagina-functions.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');
require_once('scripts/product-info-function.php');

placeItem($dbh, 1);

function placeItem($dbh, $id)
{
// TODO: ID moet worden aangepast aan het item.
    $timeOfEnding = getAuctionEnd($dbh, $id);
    $minBid = calcMinBid($dbh, $id);


    echo '
<ul class="uk-breadcrumb">
    <li><a href="#">Item</a></li>
    <li><a href="#">Item</a></li>
    <li class="uk-disabled"><a>Disabled</a></li>
    <li><span>Active</span></li>
</ul>

<div class="uk-grid" data-uk-grid-margin="">

    <div class="uk-width-1-2 uk-row-first uk-display-inline ">
        <img class="uk-margin-detail"
             src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjYwcHgiIGhlaWdodD0iNDAwcHgiIHZpZXdCb3g9IjAgMCA2NjAgNDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2NjAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSI2NjAiIGhlaWdodD0iNDAwIi8+DQo8ZyBvcGFjaXR5PSIwLjciPg0KCTxwYXRoIGZpbGw9IiNEOEQ4RDgiIGQ9Ik0yNTguMTg0LDE0My41djExM2gxNDMuNjMydi0xMTNIMjU4LjE4NHogTTM5MC4yNDQsMjQ0LjI0N0gyNzAuNDM3di04OC40OTRoMTE5LjgwOEwzOTAuMjQ0LDI0NC4yNDcNCgkJTDM5MC4yNDQsMjQ0LjI0N3oiLz4NCgk8cG9seWdvbiBmaWxsPSIjRDhEOEQ4IiBwb2ludHM9IjI3Ni44ODEsMjM0LjcxNyAzMDEuNTcyLDIwOC43NjQgMzEwLjgyNCwyMTIuNzY4IDM0MC4wMTYsMTgxLjY4OCAzNTEuNTA1LDE5NS40MzQgDQoJCTM1Ni42ODksMTkyLjMwMyAzODQuNzQ2LDIzNC43MTcgCSIvPg0KCTxjaXJjbGUgZmlsbD0iI0Q4RDhEOCIgY3g9IjMwNS40MDUiIGN5PSIxNzguMjU3IiByPSIxMC43ODciLz4NCjwvZz4NCjwvc3ZnPg0K"
             alt="">
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
        <input class="uk-input" type="text" placeholder="$">
    </div>
            <div class="uk-width-1-4@s uk-align-right">
        <input class="uk-input" type="text" value= "'. $minBid .'">
    </div><br>
            <button class="uk-button uk-button-danger uk-align-left">Bied direct</button>
            <button class="uk-button uk-button-danger uk-align-right">Bied minimum</button>
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

    getRelevantItems($dbh, 1);

    echo '
    </div>
    </p></div>
';


}


require_once('scripts/footer.php');
?>
