<?php
require_once ('scripts/header.php');
include ('scripts/AuctionItem.php');
?>




<body>


<ul class="uk-switcher uk-margin">
    <li class="uk-active"><div class="uk-card uk-card-default uk-width-1-2@m">

            <?php

            createItem();

            ?>

        </div></li>
</ul>




</body>