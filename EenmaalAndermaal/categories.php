<?php
require_once('scripts/database-connect.php');
require_once('scripts/header.php');
require_once('scripts/categoriesFunctions.php');

echo getAlphabetList();
echo getCategoryOverview($dbh);
?>


