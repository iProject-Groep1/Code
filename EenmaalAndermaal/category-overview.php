<?php
$pageTitle = 'Rubrieken';
require_once('scripts/database-connect.php');
require_once('scripts/header.php');
require_once('scripts/category-overview-functions.php');

if (isset($_SESSION['overBidMelding']) && !empty($_SESSION['overBidMelding'])) {
    echo $_SESSION['overBidMelding'];
    $_SESSION['overBidMelding'] = "";
}

//echo getAlphabetList();
echo getCategoryOverview($dbh);


require_once('scripts/footer.php');
?>