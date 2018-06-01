<?php
ob_start();
$pageTitle = "Verkoper worden";
require_once('scripts/header.php');
require_once('scripts/become-seller-functions.php');
require_once('scripts/database-connect.php');
?>

    <h2 class="uk-text-center">Verkoper worden</h2>
    <div class="uk-card uk-card-default uk-card-body uk-width-2-5@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
        <h3 class="uk-card-title uk-text-center">Vul onderstaand formulier in en klik op "Verder".</h3>
        <p class="uk-text-warning uk-text-center">Wanneer dit proces geslaagd is zal u verkoper zijn op het account met
            de volgende gebruikersnaam: "<?= $_SESSION['username'] ?>"</p>

        <form method="POST" action="scripts/become-seller-functions.php">
            <!-- TODO: maxlengths -->
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="paymentMethod">Verificatiemethode
                    :</label>
                <div class="uk-margin uk-grid-small uk-child-width-1-3 uk-grid">
                    <label><input class="uk-radio" type="radio" name="verificationMethod" value="Post" checked> Post</label>
                    <label><input class="uk-radio" type="radio" name="verificationMethod" value="Creditcard"> Creditcard</label>
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="creditCardNumber">Creditcardnummer
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: credit-card"></span>
                    <input class="uk-input" type="text" placeholder="Creditcardnummer" name="creditCardNumber"
                           id="creditCardNumber"
                           maxlength="20" required>
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="paymentMethod">Betaalwijze*
                    :</label>
                <select class="uk-select uk-width-2-3" name="paymentMethod" id="paymentMethod"
                        required><?= getPaymentMethodList($dbh) ?></select>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="bankAccountNumber">Creditcardnummer
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: credit-card"></span>
                    <input class="uk-input" type="text" placeholder="Rekeningnummer" name="bankAccountNumber"
                           id="bankAccountNumber"
                           maxlength="20" required>
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="password">Creditcardnummer
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input class="uk-input" type="text" placeholder="Wachtwoord" name="password" id="password"
                           maxlength="20" required>
                </div>
            </div>
            <div class="uk-margin uk-flex uk-flex-center ">
                <div class="uk-inline uk-width-2-3">
                    <input class="uk-input uk-button-primary" type="submit" name="submit" value="Verder">
                </div>
            </div>
        </form>
    </div>

<?php
include_once('scripts/footer.php');