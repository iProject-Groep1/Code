<?php
$pageTitle = "Upload rubriek";
require('scripts/header.php');
include('scripts/database-connect.php');

if (isset($_SESSION['fillEverything']) && !empty($_SESSION['fillEverything'])) {
    echo $_SESSION['fillEverything'];
    $_SESSION['fillEverything'] = "";
}

if (isset($_SESSION['fillEverything2']) && !empty($_SESSION['fillEverything2'])) {
    echo $_SESSION['fillEverything2'];
    $_SESSION['fillEverything2'] = "";
}

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    //Haalt de status van een gebruiker op (verkoper of geen verkoper).
    $data = "";
    try {
        $stmt = $dbh->prepare("SELECT verkoper FROM gebruiker WHERE gebruikersnaam like :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    ?>
    <h2 class="uk-text-center">Zoek uw rubriek</h2>
    <div class="uk-margin-left@l uk-margin-left@m">

        <div class="profile-sidebar uk-align-center@m">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
                <li class="uk-parent uk-open">
                    <a href="#">EenmaalAndermaal</a>
                    <ul class="uk-nav-sub" aria-hidden="false">
                        <li><a href="profile.php"><span uk-icon="user" class="uk-margin-small-right"></span>Mijn Profiel</a>
                        </li>
                        <li><a href="changeProfile.php"><span uk-icon="pencil" class="uk-margin-small-right"></span>Gegevens
                                wijzigen</a></li>
                        <li><a href="showBids.php"><span uk-icon="cart" class="uk-margin-small-right"></span>Mijn
                                Biedingen</a></li>
                        <?php
                        if ($data['verkoper'] == 0) {
                            ?>
                            <li><a href="become-seller.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Verkoper
                                    worden</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="myAuctions.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Mijn
                                    Veilingen</a></li>
                            <li><a class="uk-button uk-button-primary" href="search-Rubriek.php"><span uk-icon="plus"
                                                                                                       class="uk-margin-small-right"></span>Plaats
                                    Advertentie</a>
                            </li>
                            <?php
                        } ?>

                    </ul>
                </li>
            </ul>
        </div>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@s uk-width-1-2@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
            <div class="uk-overflow-auto">
                <!-- gebruikersinformatie -->
                <form class="uk-form-horizontal uk-margin-large" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                      method="post">
                    <div class="uk-margin">
                        <p class="uk-text-primary">Typ de rubriek in waar u uw product in wil plaatsen.</p>
                        <label class="uk-form-label" for="form-horizontal-text">Zoek uw rubriek</label>

                        <div class="uk-form-controls">

                            <input class="uk-input" id="form-horizontal-text" type="text"
                                   placeholder="Rubrieknaam" name="search">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <input class="uk-button uk-button-primary uk-button-reset" id="form-horizontal-text"
                               type="submit"
                               placeholder="Zoek" name="submit">
                    </div>

                    <?php
                    require_once('scripts/search-rubriek-functions.php');
                    if (isset($_POST['search']) && !empty($_POST['search'])) {
                        echo '<p class="uk-form-label-font">Klik op uw rubriek.</p>';
                        searchRubriek($dbh, '' . $_POST['search'] . '');
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <?php
} else {
    header('Location: login.php');
}
include('scripts/footer.php');
?>