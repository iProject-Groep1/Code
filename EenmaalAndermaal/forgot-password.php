<?php
$pageTitle = "Wachtwoordherstel";
require_once('scripts/header.php');
require_once('scripts/database-connect.php');
require_once('scripts/forgot-password-functions.php');

if (isset($_SESSION['forgotPasswordNotification']) && !empty($_SESSION['forgotPasswordNotification'])) {
    echo $_SESSION['forgotPasswordNotification'];
    $_SESSION['forgotPasswordNotification'] = "";
}

if (isset($_SESSION['questionNotification']) && !empty($_SESSION['questionNotification'])) {
    echo $_SESSION['questionNotification'];
    $_SESSION['questionNotification'] = "";
}


?>
    <h2 class="uk-text-center">Herstel uw wachtwoord.</h2>
<?php

if(isset($_GET['username']) && !empty($_GET['username'])) {
    $mail = "";
    $question = "";
    if (usernameValid($_GET['username'], $dbh)) {
        try{
            $stmt = $dbh->prepare("SELECT mail_adres, vraagtekst FROM Gebruiker JOIN Vraag ON vraag = vraagnummer WHERE gebruikersnaam LIKE :username");
            $stmt->bindValue(":username", $_GET['username'], PDO::PARAM_STR);
            $stmt->execute();
            if($results = $stmt->fetch()){
                //vervangt alles tussen de eerste en laatste letter van de email gebruikersnaam met *
                $mail = preg_replace("/(?!^).(?=[^@]+@)/", "*", $results['mail_adres']);
                $question = $results['vraagtekst'];
            }

        }
        catch(PDOException $e){
            echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
        }
        ?>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@s uk-width-1-3@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
            <h3 class="uk-card-title uk-text-center">Beantwoord de geheime vraag</h3>
            <p class="uk-text-primary uk-text-center">Als u de geheime vraag goed beantwoord krijgt u een e-mail met een nieuw wachtwoord gestuurd op het volgende adres: <?=$mail?></p>
            <p class="uk-text-warning uk-text-center">Vraag: "<?=$question?>"</p>
            <form method="POST" action="scripts/forgot-password-functions.php">

                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: question"></span>
                        <input class="uk-input" type="text" name="questionAnswer" id="questionField" placeholder="Antwoord"
                               value="" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <input type="hidden" name="hiddenUsername" id="hiddenUsername" value="<?=$_GET['username']?>">
                        <input class="uk-input uk-button-primary" type="submit" name="passwordResetQuestionSubmit "
                               id="passwordResetQuestionSubmit" value="Verder">

                    </div>
                </div>
            </form>
        </div>

        <?php
    } else {
        header('Location: forgot-password.php');
    }
} else {
    ?>

    <div class="uk-card uk-card-default uk-card-body uk-width-1-2@s uk-width-1-3@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
        <h3 class="uk-card-title uk-text-center">Vul hieronder uw gebruikersnaam in.</h3>
        <p class="uk-text-primary uk-text-center">Hierna moet u antwoord geven op de geheime vraag die u tijdens de
            registratie heeft ingesteld.</p>

        <form method="POST" action="scripts/forgot-password-functions.php">

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input class="uk-input" type="text" name="username" id="usernameField" placeholder="Gebruikersnaam"
                           value="" required>


                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <input class="uk-input uk-button-primary" type="submit" name="passwordResetSubmit "
                           id="passwordResetSubmit" value="Verder">
                </div>
            </div>


        </form>

    </div>
    <?php
}



include_once('scripts/footer.php');