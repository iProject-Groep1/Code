<?php
$pageTitle = 'Error!';
require_once('scripts/header.php');


?>


    <div class="uk-flex uk-flex-around uk-margin-top uk-margin-bottom uk-margin-auto" uk-grid>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-flex uk-flex-column">
            <h1 class="uk-card-tile uk-text-center uk-margin-bottom">Oeps!</h1>

            <?php if (isset($_GET['err'])) {
                if ($_GET['err'] == 404) {
                    echo '<h3 class="uk-card-title uk-text-center uk-margin-bottom">De pagina die u probeert te bereiken bestaat niet.</h3>';
                }
                if($_GET['err'] == 500){
                    echo '<h3 class="uk-card-title uk-text-center uk-margin-bottom">Er ging iets mis met onze database. Probeer het later opnieuw.</h3>';
                }
            } else{
                echo '<h3 class="uk-card-title uk-text-center uk-margin-bottom">Er is een fout opgetreden.</h3>';
            }?>

            <!-- TODO: ander plaatje voor database error (500) -->
            <div class="uk-align-center ">
                <img width="auto" height="400"
                     src="images/404error.png"
                     alt="Plaatje 404 error">
            </div>
            <hr class="uk-divider-icon">

            <p class="uk-text-center">Klik <a href="index.php">hier</a> om terug te gaan naar de homepagina.</p>
        </div>
    </div>


<?php
require_once('scripts/footer.php');