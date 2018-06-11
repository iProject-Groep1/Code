<?php
$pageTitle = "Mijn Profiel";
require('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country.php');

if(isset($_SESSION['noChance']) && !empty($_SESSION['noChance'])) {
    echo $_SESSION['noChance'];
    $_SESSION['noChance'] = "";
}

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

    <h2 class="uk-text-center">Gegevens wijzigen</h2>
    <div class="uk-margin-left@l uk-margin-left@m">

    <div class="profile-sidebar uk-align-center@m">
        <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
            <li class="uk-parent uk-open">
                <a href="#">EenmaalAndermaal</a>
                <ul class="uk-nav-sub" aria-hidden="false">
                    <li><a href="profile.php"><span uk-icon="user" class="uk-margin-small-right"></span>Mijn Profiel</a></li>
                    <li><a href="changeProfile.php"><span uk-icon="pencil" class="uk-margin-small-right"></span>Gegevens wijzigen</a></li>
                    <li><a href="showBids.php"><span uk-icon="cart" class="uk-margin-small-right"></span>Mijn Biedingen</a></li>
                    <?php
                    if ($data['verkoper'] == 0) {
                        ?>
                        <li><a href="become-seller.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Verkoper worden</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="myAuctions.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Mijn Veilingen</a></li>
                        <li><a class="uk-button uk-button-primary" href="search-Rubriek.php"><span uk-icon="plus" class="uk-margin-small-right"></span>Plaats Advertentie</a>
                        </li>
                        <?php
                    } ?>

                </ul>
            </li>
        </ul>
    </div>
    <div class="uk-grid uk-align-center uk-card-refactor2 uk-flex uk-flex-center auctions-reset-margin">
    <div class="uk-grid uk-flex uk-grid flex-space-evenly">
        <div class="uk-align-card uk-card uk-card-default uk-card-body uk-width-1-1@s uk-width-2-3@m uk-width-1-2@l uk-width-2-5@xl uk-margin-medium-top uk-margin-large-bottom uk-display-inline-block uk-a">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle uk-grid" uk-grid="">
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom uk-text-center ">Persoonlijke gegevens</h3>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>
                    <form method="POST" action="scripts/change-personal-information.php">
                        <fieldset class="uk-fieldset">

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Voornaam: </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" name="firstname" id="form-horizontal-text" type="text"
                                           value="<?= $data['voornaam'] ?>" maxlength="25" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Achternaam: </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" name="lastname" id="form-horizontal-text" type="text"
                                           value="<?= $data['achternaam'] ?>" maxlength="30" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Geboortedatum: </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" name="birthday" id="form-horizontal-text" type="date" value="<?= $data['geboortedag'] ?>" max="<?=date('Y-m-d', strtotime("-18 year", time()))?>" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Eerste adres: </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="text"
                                           value="<?= $data['adresregel1'] ?>" name="adres1" maxlength="30" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Postcode: </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="text"
                                           value="<?= $data['postcode'] ?>" name="postalCode" maxlength="7" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Plaatsnaam: </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="text"
                                           value="<?= $data['plaatsnaam'] ?>" name="placeName" maxlength="40" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Land: </label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" name="country"required >
                                        <option value="<?= $data['land'] ?>"><?= $data['land'] ?></option>
                                        <?= Get_country($dbh) ?>
                                    </select>
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

        <div class="uk-card uk-card-default uk-card-body uk-width-1-1@s uk-width-2-3@m uk-width-1-2@l uk-width-2-5@xl uk-margin-medium-top uk-margin-large-bottom uk-display-inline-block">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle uk-grid" uk-grid="">
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom uk-text-center ">E-mailadres</h3>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>
                    <form method="POST" action="scripts/change-e-mail.php">
                        <fieldset class="uk-fieldset">
                            <h4>Uw huidige e-mailadres is <?= $data['mail_adres'] ?></h4>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Huidige wachtwoord* </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="password"
                                           placeholder="Wachtwoord" name="password" required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-horizontal-text">Nieuw e-mailadres* </label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" id="form-horizontal-text" type="text"
                                           placeholder="Nieuw e-mailadres" name="newMail" required>
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
    </div>
    <?php

} else {
    header('Location: login.php?');
}


include('scripts/footer.php');
