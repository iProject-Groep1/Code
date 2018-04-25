<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
?>


<body>

<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

    <?php

    for ($i = 1; $i < 9; $i++) {
        createItem("iPad Pro", calcNewEndTime(0, $i, 0, 0));
    }
    //        createItem("iPad Pro", 5);
    //        createItem("iPad Pro", 6);

    ?>

</div>

<?php
require_once('scripts/footer.php');
?>

</body>

