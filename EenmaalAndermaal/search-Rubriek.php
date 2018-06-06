<?php
$pageTitle = "Upload rubriek";
require('scripts/header.php');
include('scripts/database-connect.php');


    ?>

    <h2 class="uk-text-center">Zoek uw rubriek</h2>
    <div class="uk-margin-left@l uk-margin-left@m">
        <div class="profile-sidebar uk-align-center@m">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
                <li class="uk-parent uk-open">
                    <a href="#">EenmaalAndermaal</a>
                    <ul class="uk-nav-sub" aria-hidden="false">
                        <li><a href="profile.php">Mijn Profiel</a></li>
                        <li><a href="changeProfile.php">Gegevens wijzigen</a></li>
                        <li><a href="myAuctions.php">Mijn Veilingen</a></li>
                        <li><a href="showBids.php">Mijn Biedingen</a></li>
                        <li><a class="uk-button uk-button-primary" href="search-Rubriek.php">Plaats Advertentie</a></li>
                    </ul>
                </li>
            </ul>
        </div>


        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@s uk-width-1-3@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
            <div class="uk-overflow-auto">
                <!-- gebruikersinformatie -->
                    <form class="uk-form-horizontal uk-margin-large" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Zoek uw rubriek</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-horizontal-text" type="text"
                                       placeholder="Rubrieknaam" name="search">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <input class="uk-button uk-button-primary uk-button-reset" id="form-horizontal-text" type="submit"
                                   placeholder="Zoek" name="submit">
                        </div>

                        <?php
                        require_once('scripts/search-rubriek-functions.php');
                        if(isset($_POST['search']) && !empty($_POST['search'])) {
                            searchRubriek($dbh, '' . $_POST['search'] . '');
                        }
                        ?>
                </form>
            </div>
        </div>
    </div>

    <?php
include('scripts/footer.php');
?>