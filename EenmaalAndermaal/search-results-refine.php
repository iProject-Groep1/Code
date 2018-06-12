<?php
$pageTitle = 'SearchResultsRefine';
include('scripts/header.php');
include('scripts/search.php');
include('scripts/database-connect.php');

if (isset($_POST['submit'])) {
    ?>
    <div class="uk-grid">
        <div class="uk-width-3-4" style="display:inline; margin-left: 20px;">
            <div class="uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body">
                <h3 class="uk-display-block uk-align-left uk-text-center">Zoekresultaten </h3>
                <p>
                <div class="uk-breadcrumb2 uk-grid uk-align-left uk-width-medium-1-4 uk-flex uk-flex-left auctions-reset-margin">
                    <?php $echo = getVerfijn($dbh);
                    echo $echo;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('scripts/footer.php');
?>
