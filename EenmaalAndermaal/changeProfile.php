<?php
$pageTitle = "Mijn Profiel";
require('scripts/header.php');
include('scripts/database-connect.php');


if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {

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

    ?>

    <h1 class="uk-text-center">Gegevens wijzigen</h1>

    <div class="profile-sidebar uk-align-center@m">
        <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
            <li class="uk-parent uk-open">
                <a href="#">EenmaalAndermaal</a>
                <ul class="uk-nav-sub" aria-hidden="false">
                    <li
                    "><a href="profile.php">Mijn Profiel</a></li>
                    <li><a href="">Gegevens wijzigen</a></li>
                    <li>
                        <a href="#">Mijn Veilingen</a>
                    </li>
                    <li><a href="#">Mijn Biedingen</a></li>
                    <li> <a class="uk-button uk-button-primary" href="#">Plaats Advertentie</a></li>
                </ul>
            </li>
        </ul>

    </div>


        <div class="uk-card uk-card-default uk-width-1-3@m uk-display-inline-block margin-card-left">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle uk-grid" uk-grid="">
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom uk-text-center ">Persoonlijke gegevens</h3>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>
                <form>
                    <fieldset class="uk-fieldset">

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Voornaam: </label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-horizontal-text" type="text" placeholder="Voornaam">
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Achternaam: </label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-horizontal-text" type="text" placeholder="Achternaam">
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Geboortedatum: </label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-horizontal-text" type="date">
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Mobiele telefoonnummer: </label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-horizontal-text" type="text"
                                       placeholder="telefoonnummer">
                            </div>
                        </div>

                        <hr class="uk-divider-icon">

                <p class="uk-text-left uk-display-inline">*Verplicht veld</p>

                <div class="uk-inline uk-align-right uk-width-1-3">
                    <input class="uk-input uk-button-primary" type="submit" name="submit " id="loginSubmit"
                           value="Opslaan">
                </div>

                    </fieldset>
                </form>

                </p>
            </div>
        </div>


        <div class="uk-card uk-card-default uk-width-1-3@m uk-display-inline-block margin-card-left">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle uk-grid" uk-grid="">
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom uk-text-center ">E-mailadres</h3>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>
                    <form>
                        <fieldset class="uk-fieldset">

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">E-mailadres* </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="text"
                                           placeholder="Voornaam">
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Wachtwoord* </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="password"
                                           placeholder="Wachtwoord">
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Nieuw Wachtwoord* </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="password"
                                           placeholder="Nieuw Wachtwoord">
                                </div>
                            </div>


                            <hr class="uk-divider-icon">

                <p class="uk-text-left uk-display-inline">*Verplicht veld</p>

                    <div class="uk-inline uk-align-right uk-width-1-3">
                        <input class="uk-input uk-button-primary" type="submit" name="submit " id="loginSubmit"
                               value="Opslaan">
                </div>


                </fieldset>
                </form>

                </p>
            </div>
        </div>
    </div>
    <?php

} else {
    //TODO netjes naar inlogpagina sturen met melding "u moet inloggen".
    header('Location: errorpage.php?err=404');

}


include('scripts/footer.php');
