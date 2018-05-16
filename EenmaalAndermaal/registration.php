<?php
require_once('scripts/header.php');
include('scripts/homepage-functions.php');

if(isset($_SESSION['emailMelding']) && !empty($_SESSION['emailMelding'])) {
    echo $_SESSION['emailMelding'];
    $_SESSION['emailMelding'] = "";
    session_unset();
}

if(isset($_SESSION['regMelding']) && !empty($_SESSION['regMelding'])) {
    echo $_SESSION['regMelding'];
    $_SESSION['regMelding'] = "";
    session_unset();
}
if(isset($_SESSION['regSucceedMelding']) && !empty($_SESSION['regSucceedMelding'])) {
    echo $_SESSION['regSucceedMelding'];
    $_SESSION['regSucceedMeldingMelding'] = "";
    session_unset();
}
?>

<div class="uk-flex uk-flex-around uk-margin-xlarge-top uk-margin-xlarge-bottom uk-margin-auto" uk-grid>
    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">1. Vul je email-adres hieronder in en klik op
            "Registreer".</h3>

        <form action="scripts/registration-functions.php" method="post">


            <input class="uk-input" type="text" placeholder="Email" name="email">

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">

                    <input class="uk-input uk-button-primary" id="loginSubmit" type="submit" value="Registreer"
                    name="submit">

                </div>
            </div>

        </form>
    </div>

    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-flex uk-flex-column">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">2. Kijk in je inbox en klik op de link.</h3>

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

//<div class="uk-margin">
//                    <div class="uk-inline">
//                        <span class="uk-form-icon uk-form-icon-flip uk-icon" uk-icon="icon: lock"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" ratio="1"> <rect fill="none" stroke="#000" height="10" width="13" y="8.5" x="3.5"></rect> <path fill="none" stroke="#000" d="M6.5,8 L6.5,4.88 C6.5,3.01 8.07,1.5 10,1.5 C11.93,1.5 13.5,3.01 13.5,4.88 L13.5,8"></path></svg></span>
//                        <input class="uk-input" type="text" placeholder="Verification Code" name="hash">
//                    </div>
//                </div>


?>
