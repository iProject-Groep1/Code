<?php

$pageTitle = "Mijn Profiel";
require('scripts/header.php');
include('scripts/database-connect.php');


if (isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($_GET['Rubriek']) && !empty($_GET['Rubriek'])) {


    //haal bijna alle informatie van een gebruiker op
//TODO query aanpassen zodat gemiddelde feedback en telefoonnummers mee wordt genomen.
    $data = "";
    try {
        $stmt = $dbh->prepare("SELECT gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mail_adres, verkoper FROM gebruiker WHERE gebruikersnaam LIKE :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }

    $Rubriek = $_GET['Rubriek'];

echo '
    <h1 class="uk-center-upload">Plaats Advertentie</h1>
    <p class=" uk-center-upload ">'.$Rubriek . ' </p>
    <div class="uk-align-left profile-sidebar uk-align-center@m uk-display-block uk-width-1-2@s uk-width-1-6@m">
        <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
            <li class="uk-parent uk-open">
                <a href="#">EenmaalAndermaal</a>
                <ul class="uk-nav-sub" aria-hidden="false">
                    <li><a href="profile.php">Mijn Profiel</a></li>
                    <li><a href="changeProfile.php">Gegevens wijzigen</a></li>
                    <li><a href="#">Mijn Veilingen</a></li>
                    <li><a href="#">Mijn Biedingen</a></li>
                    <li><a class="uk-button uk-button-primary" href="search-Rubriek.php">Plaats Advertentie</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="" uk-grid>
        <div class="uk-card-refactor auctions-reset-margin uk-display-inline-block">
            <img class="uk-display-block" src="images/placeholde-img.png" alt="placeholder" width="300">
        </div>
        <div class="uk-display-inline-block uk-width-1-2@s uk-width-1-3@m">
            <form class="uk-form-horizontal uk-margin-large">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Titel</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text"
                               placeholder="Titel">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Startprijs</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text"
                               placeholder="0">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Verzendkosten</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text"
                               placeholder="0">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Betalingswijze</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text"
                               placeholder="IDEAL">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-select">Veilingtijd</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="form-horizontal-select">
                            <option default>1 Dag</option>
                            <option>3 Dagen</option>
                            <option>5 Dagen</option>
                            <option>7 Dagen</option>
                            <option>10 Dagen</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="uk-card-refactor auctions-reset-margin uk-display-inline-block uk-margin-top-zero">
            <div class="js-upload uk-placeholder uk-text-center uk-upload-picture">
                <span uk-icon="icon: cloud-upload"></span>
                <span class="uk-text-middle">Sleep hier een foto in of </span>
                <div uk-form-custom>
                    <input type="file" multiple>
                    <span class="uk-link">selecteer er een</span>
                </div>
            </div>

            <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

';
?>

            <script>

                var bar = document.getElementById('js-progressbar');

                UIkit.upload('.js-upload', {

                    url: 'images',
                    multiple: true,

                    beforeSend: function () {
                        console.log('beforeSend', arguments);
                    },
                    beforeAll: function () {
                        console.log('beforeAll', arguments);
                    },
                    load: function () {
                        console.log('load', arguments);
                    },
                    error: function () {
                        console.log('error', arguments);
                    },
                    complete: function () {
                        console.log('complete', arguments);
                    },

                    loadStart: function (e) {
                        console.log('loadStart', arguments);

                        bar.removeAttribute('hidden');
                        bar.max = e.total;
                        bar.value = e.loaded;
                    },

                    progress: function (e) {
                        console.log('progress', arguments);

                        bar.max = e.total;
                        bar.value = e.loaded;
                    },

                    loadEnd: function (e) {
                        console.log('loadEnd', arguments);

                        bar.max = e.total;
                        bar.value = e.loaded;
                    },

                    completeAll: function () {
                        console.log('completeAll', arguments);

                        setTimeout(function () {
                            bar.setAttribute('hidden', 'hidden');
                        }, 1000);

                        alert('Upload Completed');
                    }

                });

            </script>
        </div>

        <div class="uk-card-refactor auctions-reset-margin uk-display-inline-block uk-margin-top-zero">
            <form class="uk-form-horizontal uk-margin-large">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-select">Beschrijving</label>
                    <textarea class="uk-textarea" rows="5" placeholder="Textarea"></textarea>
                </div>
            </form>
        </div>
    </div>

        <div class="uk-card-refactor2 auctions-reset-margin uk-display-inline-block uk-margin-top-zero">
            <a class="uk-button uk-button-primary uk-button-reset" href="#">Plaats Advertentie</a>
        </div>

    <?php

} else {
    //TODO netjes naar inlogpagina sturen met melding "u moet inloggen".
    header('Location: errorpage.php?err=404');

}


include('scripts/footer.php');
