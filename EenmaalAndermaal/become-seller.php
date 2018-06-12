<?php
ob_start();
$pageTitle = "Verkoper worden";
require_once('scripts/header.php');
require_once('scripts/become-seller-functions.php');
require_once('scripts/database-connect.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    $_SESSION['logMelding'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> U moet inloggen om deze pagina te bezoeken.\', status: \'danger\'})</script>';
    header('Location: login.php');
}

if (isset($_SESSION['becomeSellerFormNotification']) && !empty($_SESSION['becomeSellerFormNotification'])) {
    echo $_SESSION['becomeSellerFormNotification'];
    $_SESSION['becomeSellerFormNotification'] = "";
}

//stuur terug wanneer je al verkoper bent
try {
    $stmt = $dbh->prepare("SELECT verkoper FROM Gebruiker where gebruikersnaam LIKE :gebruikersnaam");
    $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    if ($data = $stmt->fetch()) {
        if ($data['verkoper'] == 1) {
            $_SESSION['profileNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> U bent al verkoper!\', status: \'danger\'})</script>';
            header('Location: profile.php');
        }
    }
} catch (PDOException $e) {
    echo "Fout" . $e->getMessage();
}

?>
    <h2 class="uk-text-center">Verkoper worden</h2>
 <div class="uk-margin-left@l uk-margin-left@m">

    <div class="profile-sidebar uk-align-center@m">
        <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
            <li class="uk-parent uk-open">
                <a href="#">EenmaalAndermaal</a>
                <ul class="uk-nav-sub" aria-hidden="false">
                    <li><a href="profile.php"><span uk-icon="user" class="uk-margin-small-right"></span>Mijn Profiel</a></li>
                    <li><a href="change-profile.php"><span uk-icon="pencil" class="uk-margin-small-right"></span>Gegevens wijzigen</a></li>
                    <li><a href="show-bids.php"><span uk-icon="cart" class="uk-margin-small-right"></span>Mijn Biedingen</a></li>
                    <?php
                    if ($data['verkoper'] == 0) {
                        ?>
                        <li><a href="become-seller.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Verkoper worden</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="my-auctions.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Mijn Veilingen</a></li>
                        <li><a class="uk-button uk-button-primary" href="search-Rubriek.php"><span uk-icon="plus" class="uk-margin-small-right"></span>Plaats Advertentie</a>
                        </li>
                        <?php
                    } ?>

                </ul>
            </li>
        </ul>
    </div>
<?php
if (!isset($_GET['verification'])) {
    ?>

    <div class="uk-card uk-card-default uk-card-body uk-width-2-5@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
        <h3 class="uk-card-title uk-text-center">Vul onderstaand formulier in en klik op "Verder".</h3>
        <p class="uk-text-warning uk-text-center">Wanneer dit proces geslaagd is zal u verkoper zijn op het account met
            de volgende gebruikersnaam: "<?= $_SESSION['username'] ?>"</p>

        <form method="POST" action="scripts/become-seller-functions.php">
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
                           max="9999999999999999">
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
                           maxlength="34">
                </div>
            </div>
            <div class="uk-margin uk-form-horizontal">
                <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="password">Wachtwoord
                    :</label>
                <div class="uk-inline uk-width-2-3">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input class="uk-input" type="password" placeholder="Wachtwoord" name="password" id="password"
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
                    <input class="uk-input" type="text" placeholder="Verificatiecode" name="verificationCode"
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
?>
 </div>
     <?php
include_once('scripts/footer.php');