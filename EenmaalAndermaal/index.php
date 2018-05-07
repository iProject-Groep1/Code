<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
include('scripts/database-connect.php')
?>


<body>

<div class="uk-grid  uk-flex uk-flex-center auctions-reset-margin">

    <?php
    $AllItems = checkNumbers($dbh);
    print_r($AllItems);
    ?>

</div>


<?php
require_once('scripts/footer.php');
?>

</body>

