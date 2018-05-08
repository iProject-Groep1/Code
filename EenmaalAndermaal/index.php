<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
include('scripts/database-connect.php')
?>


<body>

<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
    <h3 class="uk-display-block uk-align-center uk-text-center">Populairste veilingen</h3>
    <p>


    <div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

        <?php


        getPopularItems($dbh);

        ?>

    </div>
    </p></div>


<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
    <h3 class="uk-display-block uk-align-center uk-text-center">Duurste veilingen</h3>
    <p>

    <div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

        <?php
        getHighItems($dbh);
        ?>

    </div>
    </p></div>


<?php
require_once('scripts/footer.php');
?>

</body>

