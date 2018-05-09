<?php
require_once('scripts/database-connect.php');
require_once('scripts/header.php');
require_once('scripts/category-overview-functions.php');

//echo getAlphabetList();
echo getCategoryOverview($dbh);



require_once('scripts/footer.php');
?>