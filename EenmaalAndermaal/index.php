<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
include('scripts/database-connect.php')
?>


<body>

<h3 class="uk-display-block uk-align-center uk-text-center"> Populairste veilingen </h3><br>
<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

    <?php

    /* Dit is de functie die random auctions laat zien
    checkNumbers($dbh); */

    getpopularitem($dbh);

    ?>

</div><br>
        <hr class="uk-margin-large">


<?php
require_once('scripts/footer.php');
?>

</body>

