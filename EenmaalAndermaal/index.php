<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
?>


<body>

<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

    <?php
        createItem("iPad Pro", calcEndTime(0, 2, 15, 0));
        createItem("iPad Pro", calcEndTime(0, 4, 30, 0));
        createItem("iPad Pro", calcEndTime(0, 5, 0, 0));
        createItem("iPad Pro", calcEndTime(0, 7, 15, 0));
        createItem("iPad Pro", calcEndTime(0, 8, 0, 0));
        createItem("iPad Pro", calcEndTime(0, 9, 45, 0));
    ?>

</div>

<?php
require_once('scripts/footer.php');
?>

</body>

