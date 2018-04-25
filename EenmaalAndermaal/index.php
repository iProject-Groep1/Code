<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
?>


<body>

<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin" >

        <?php

        createItem("iPad Pro", "2018-04-25T09:00:00+00:00");
        createItem("iPad Pro","2018-04-25T10:00:00+00:00");
//        createItem("iPad Pro", 3);
//        createItem("iPad Pro", 4);
//        createItem("iPad Pro", 5);
//        createItem("iPad Pro", 6);

        ?>

</div>


</body>