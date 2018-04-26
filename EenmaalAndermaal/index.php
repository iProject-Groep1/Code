<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
include('scripts/database-connect.php')
?>


<body>

<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

    <?php

    createItem($dbh, "iPad Pro", makeTimeSyntax($dbh, calcAuctionTime($dbh, 6)));
    createItem($dbh, "iPad Pro", makeTimeSyntax($dbh, calcAuctionTime($dbh, 6)));
    createItem($dbh, "iPad Pro", makeTimeSyntax($dbh, calcAuctionTime($dbh, 6)));
    createItem($dbh, "iPad Pro", makeTimeSyntax($dbh, calcAuctionTime($dbh, 6)));

    ?>

</div>


<?php
require_once('scripts/footer.php');
?>

</body>

