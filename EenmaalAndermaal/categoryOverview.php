<?php
require_once('scripts/database-connect.php');
require_once('scripts/header.php');
require_once('scripts/categoryOverviewFunctions.php');

//echo getAlphabetList();
echo getCategoryOverview($dbh);
?>


<?php
require_once('scripts/footer.php');
?>