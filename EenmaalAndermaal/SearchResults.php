<?php
$pageTitle = 'SearchResults';
include('scripts/header.php');
include('scripts/search.php');
include('scripts/database-connect.php');
$searchTerm = '';
$searchTerm = htmlentities($_POST['Searching'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

?>
<div class="uk-grid">
 <div class="uk-width-3-4"style="display:inline; margin-left: 20px;">
    <div class="uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body">
<h3 class="uk-display-block uk-align-left uk-text-center">Zoekresultaten, u heeft gezocht op <?php echo '"' .$searchTerm .'"'; ?></h3>
<p>
<div class="uk-breadcrumb2 uk-grid uk-align-left uk-width-medium-1-4 uk-flex uk-flex-left auctions-reset-margin">
  <?php  searchItems($dbh)?>
</div>
</p>
</div>
</div>

<div class="uk-align-right uk-width-1-5 uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body"  >
  <h3>Geavanceerd zoeken</h3>
<form action="SearchResultsRefine.php" method="post" >
  <label for="searchterm">Zoekterm </label> <br>
  <input type="text" name="searchterm" value="<?php print ($searchTerm) ; ?>"><br>
  <label for="Rubrieken">Gevonden in de rubrieken</label> <br>
 <?php getRubrieken($dbh,$searchTerm); ?>
 <input type="submit" name="submit" value="verfijn zoekopdracht">



</form>
</div>
</div>

<div >
<hr>
</div>
<?php
include('scripts/footer.php');
 ?>
