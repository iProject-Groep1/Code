<?php
$pageTitle = 'SearchResults';
include('scripts/header.php');
include('scripts/search.php');
include('scripts/database-connect.php');


echo '<div class="uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body">
<h3 class="uk-display-block uk-align-center uk-text-center">Zoek resultaten</h3>
<p>';

echo'<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">'.searchItems($dbh).'</div>
</p>
</div>
<hr>

<div style="display:inline-block; height:50px" >

</div>';


include('scripts/footer.php');


 ?>
