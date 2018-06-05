<?php
$pageTitle = "Wachtwoord wijzigen";
require('scripts/header.php');
include('scripts/database-connect.php');

if(isset($_SESSION['noChance']) && !empty($_SESSION['noChance'])) {
    echo $_SESSION['noChance'];
    $_SESSION['noChance'] = "";
}

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {

?>
    <h2 class="uk-text-center">Wachtwoord wijzigen</h2>
    <div class="uk-margin-left@l uk-margin-left@m">

        <div class="profile-sidebar uk-align-center@m">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
                <li class="uk-parent uk-open">
                    <a href="#">EenmaalAndermaal</a>
                    <ul class="uk-nav-sub" aria-hidden="false">
                        <li><a href="profile.php">Mijn Profiel</a></li>
                        <li><a href="changeProfile.php">Gegevens wijzigen</a></li>
                        <li><a href="myAuctions.php">Mijn Veilingen</a></li>
                        <li><a href="#">Mijn Biedingen</a></li>
                        <li><a class="uk-button uk-button-primary" href="search-Rubriek.php">Plaats Advertentie</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@s uk-width-1-3@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
            <div class="uk-overflow-auto">
                <form method="POST" action="scripts/change-password-function.php">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Huidig wachtwoord*</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="currentPassword" id="form-horizontal-text" type="password" required>
                            </div>
                        </div>

                        <p class="uk-text-primary">Uw wachtwoord moet minimaal 7 karakters lang zijn en een hoofdletter en getal bevatten.</p>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Nieuw wachtwoord*</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="newPassword" id="form-horizontal-text" type="password" required>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-text">Nieuw wachtwoord opnieuw invullen*</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="confirmPassword" id="form-horizontal-text" type="password" required>
                            </div>
                        </div>

                        <hr class="uk-divider-icon">

                        <p class="uk-text-left uk-display-inline">*Verplicht veld</p>

                        <div class="uk-inline uk-align-right uk-width-1-3">
                            <input class="uk-input uk-button-primary" type="submit" name="submit" value="Opslaan">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <?php

} else {
    //TODO netjes naar inlogpagina sturen met melding "u moet inloggen".
    header('Location: errorpage.php?err=404');
}
include('scripts/footer.php');
