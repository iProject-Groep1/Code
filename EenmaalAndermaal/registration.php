<?php
$pageTitle = 'Registreren';
require_once('scripts/header.php');

if (isset($_SESSION['overBidMelding']) && !empty($_SESSION['overBidMelding'])) {
    echo $_SESSION['overBidMelding'];
    $_SESSION['overBidMelding'] = "";
}

if(isset($_SESSION['emailMelding']) && !empty($_SESSION['emailMelding'])) {
    echo $_SESSION['emailMelding'];
    $_SESSION['emailMelding'] = "";
}

if(isset($_SESSION['regMelding']) && !empty($_SESSION['regMelding'])) {
    echo $_SESSION['regMelding'];
    $_SESSION['regMelding'] = "";
}
if(isset($_SESSION['regSucceedMelding']) && !empty($_SESSION['regSucceedMelding'])) {
    echo $_SESSION['regSucceedMelding'];
    $_SESSION['regSucceedMelding'] = "";
}

if(isset($_SESSION['username'])){
    header('Location: logout.php');
}
?>

<div class="uk-flex uk-flex-around uk-margin-xlarge-top uk-margin-xlarge-bottom uk-margin-auto" uk-grid>
    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">1. Vul een geldig email-adres hieronder in en klik op
            "Registreer".</h3>

        <form action="scripts/registration-functions.php" method="post">

            <section id="email">
                <div class="uk-margin">

                    <input class="uk-input" type="email" placeholder="Email" name="email" required>

                    <script>new Awesomplete('input[type="email"]', {
                                list: ["aol.com", "att.net", "comcast.net", "facebook.com", "gmail.com", "gmx.com", "googlemail.com", "google.com", "hotmail.com", "hotmail.co.uk", "mac.com", "me.com", "mail.com", "msn.com", "live.com", "sbcglobal.net", "verizon.net", "yahoo.com", "yahoo.co.uk"],
                                data: function (text, input) {
                                    return input.slice(0, input.indexOf("@")) + "@" + text;
                                },
                                filter: Awesomplete.FILTER_STARTSWITH
                            });</script>
                </div>
            </section>

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <input class="uk-input uk-button-primary" id="registerSubmit" type="submit" value="Registreer"
                    name="submit">
                </div>
            </div>

        </form>
    </div>

    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-flex uk-flex-column">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">2. Kijk in je inbox en klik op de link. Vergeet niet in je spam folder te kijken!</h3>

        <div class="uk-align-center ">
            <img width="auto" height="400"
                 src="images/verification-email.jpg"
                 alt="Plaatje verificatie-email">
        </div>
    </div>

    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-flex uk-flex-column">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">3. Vul de rest van je gegevens in.</h3>

        <div class=" uk-align-center">
            <img width="auto" height="400"
                 src="images/registration-form.jpg"
                 alt="Plaatje registratieformulier">
        </div>
    </div>


</div>


<?php
require_once('scripts/footer.php');
?>
