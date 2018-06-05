<?php
ob_start();
$pageTitle = "Verkoper worden";
require_once('scripts/header.php');
require_once('scripts/become-seller-functions.php');
require_once('scripts/database-connect.php');

if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['username'])) {
    //TODO: melding werkend maken
    $_SESSION['logMelding'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> U moet inloggen om deze pagina te bezoeken.\', status: \'danger\'})</script>';
    header('Location: login.php');
}

if (isset($_SESSION['becomeSellerFormNotification']) && !empty($_SESSION['becomeSellerFormNotification'])) {
    echo $_SESSION['becomeSellerFormNotification'];
    $_SESSION['becomeSellerFormNotification'] = "";
}

?>
    <h2 class="uk-text-center">Verkoper worden</h2>
<?php
if(!isset($_GET['verification'])) {
    ?>

    <div class="uk-card uk-card-default uk-card-body uk-width-2-5@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
        <h3 class="uk-card-title uk-text-center">Vul onderstaand formulier in en klik op "Verder".</h3>
        <p class="uk-text-warning uk-text-center">Wanneer dit proces geslaagd is zal u verkoper zijn op het account met
            de volgende gebruikersnaam: "<?= $_SESSION['username'] ?>"</p>

        <form method="POST" action="scripts/become-seller-functions.php">
            <!-- TODO: maxlengths -->
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="paymentMethod">Verificatiemethode
                    : <span uk-icon="question"></span>
                    <div uk-drop>
                        <div class="uk-card uk-card-body uk-card-default"><p class="uk-text-primary">Wanneer u kiest
                                voor post krijgt u een brief thuisgestuurd met een verificatiecode die u moet invullen.
                                Wanneer u voor creditcard kiest nemen wij contact op met de creditcardmaatschappij en
                                krijgt u een mail wanneer uw gegevens geverifiëerd zijn.</p></div>
                    </div>
                </label>
                <div class="uk-margin uk-grid-small uk-child-width-1-3 uk-grid">
                    <label><input class="uk-radio" type="radio" name="verificationMethod" value="Post" checked>
                        Post</label>
                    <label><input class="uk-radio" type="radio" name="verificationMethod" value="Creditcard"> Creditcard</label>
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="creditCardNumber">Creditcardnummer
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: credit-card"></span>
                    <input class="uk-input" type="number" placeholder="Creditcardnummer" name="creditCardNumber"
                           id="creditCardNumber"
                           maxlength="16" required>
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="paymentMethod">Betaalwijze*
                    :</label>
                <select class="uk-select uk-width-2-3" name="paymentMethod" id="paymentMethod"
                        required><?= getPaymentMethodList($dbh) ?></select>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="bankAccountNumber">Rekeningnummer
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: credit-card"></span>
                    <input class="uk-input" type="text" placeholder="Rekeningnummer" name="bankAccountNumber"
                           id="bankAccountNumber"
                           maxlength="34" required>
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="password">Wachtwoord
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input class="uk-input" type="text" placeholder="Wachtwoord" name="password" id="password"
                           maxlength="72" required>
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
} else {
    ?>

    <div class="uk-card uk-card-default uk-card-body uk-width-2-5@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
        <h3 class="uk-card-title uk-text-center">Vul uw verificatiecode in.</h3>

        <form method="POST" action="scripts/become-seller-functions.php">
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="verificationCode">Verificatiecode
                    : </label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: check"></span>
                    <input class="uk-input" type="number" placeholder="Verificatiecode" name="verificationCode"
                           id="verificationCode"
                           maxlength="10" required>
                </div>
            </div>

            <div class="uk-margin uk-flex uk-flex-center ">
                <div class="uk-inline uk-width-2-3">
                    <input class="uk-input uk-button-primary" type="submit" name="submitVerification" value="Verder">
                </div>
            </div>
        </form>
    </div>

    <?php
}
include_once('scripts/footer.php');