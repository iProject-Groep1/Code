<?php
$pageTitle = 'SearchResultsRefine';
include('scripts/header.php');
include('scripts/search.php');
include('scripts/database-connect.php');

if(isset($_POST['submit'])){
?>  <div class="uk-grid">
   <div class="uk-width-3-4"style="display:inline; margin-left: 20px;">
      <div class="uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body">
  <h3 class="uk-display-block uk-align-left uk-text-center">Zoekresultaten  </h3>
  <p>
  <div class="uk-grid uk-align-left uk-width-medium-1-4 uk-flex uk-flex-left auctions-reset-margin">
    <?php $echo = getVerfijn($dbh); echo $echo;?>
  </div>
  </p>
  </div>
  </div>
  <div class="uk-align-right uk-width-1-5 uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body"  >
  <form class="uk-search uk-search-default uk-align-right "action="../SearchResults.php" method="post">
    <label for="searchterm">Nieuwe zoekterm</label>
    <input class="uk-search-input" type="search" name="Searching" placeholder="Search..." >
  </form>
</div>


</div>


<?php
}

include('scripts/footer.php');
?>
