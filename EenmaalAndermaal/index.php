<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
?>


<body>

<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin" >

        <?php

        createItem("iPad Pro", calcEndTime(0, 2, 0, 0));
        createItem("iPad Pro",calcEndTime(0, 1, 0, 0));
        createItem("iPad Pro", calcEndTime(0, 5, 0, 0));
        createItem("iPad Pro", calcEndTime(0, 3, 0, 0));
//        createItem("iPad Pro", 5);
//        createItem("iPad Pro", 6);

        ?>

</div>


</body>