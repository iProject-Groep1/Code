<?php
$pageTitle = 'SearchResultsRefine';
include('scripts/header.php');
include('scripts/search.php');
include('scripts/database-connect.php');

if(isset($_POST['submit'])){
  getVerfijn($dbh);
}





include('scripts/footer.php');
?>
