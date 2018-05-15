<?php
require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country.php');
include('scripts/database-connect.php');
include('scripts/question.php');

activateAccount($dbh);

function activateAccount($dbh)
{
$match = 0;
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
}

$search = $dbh->query("SELECT email, hash FROM Verificatie WHERE email='" . $email . "' AND hash='" . $hash . "'");
while ($row = $search->fetch()) {
    $match ++;
}

if ($match > 0){

    $dbh->query("UPDATE Verificatie SET isGeactiveerd='1' WHERE email='" . $email . "' AND hash='" . $hash . "'");
} else {

}

}

echo'
<body>
<form>
    <div class="uk-card uk-card-default uk-card-body uk-width-1-3@m uk-margin-auto uk-margin-top uk-margin-bottom">
      <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>
    <div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam">
        </div>
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Voornaam" name="Voornaam">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Achternaam" name="Achternaam">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Eerste adres" name="Eerste adres">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Tweede adres" name="Tweede adres">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Postcode" name="Postcode">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Plaatsnaam" name="Plaatsnaam">
    </div>
    <div class="uk-margin">
        <select class="uk-select" name="land">
        ';
        Get_country($dbh);
        echo' </select>
    </div>


    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input class="uk-input" type="text" placeholder="Wachtwoord" name="Wachtwoord">
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
<<<<<<< HEAD
<<<<<<< HEAD
            <input class="uk-input" type="text" placeholder="Wachtwoord bevestigen" name="Wachtwoord herhaal">
=======

            <input class="uk-input" type="text" placeholder="Wachtwoord bevestigen">
>>>>>>> 0cf4fbd4d4df87d11660842c366b6ae1b2df82aa
        </div>
    </div>
    <div class="uk-margin">
        <select class="uk-select" name="vraag">
        ';
        Get_question($dbh);
        echo' </select>
        <div class="uk-margin">
<<<<<<< HEAD
            <input class="uk-input" type="text" placeholder="Antwoord" name="Antwoord">
=======
            <input class="uk-input" type="text" placeholder="Antwoord">

            <input class="uk-input" type="password" placeholder="wachtwoord">

>>>>>>> 0cf4fbd4d4df87d11660842c366b6ae1b2df82aa
        </div>
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="date" name="Datum">
    </div>
    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <input class="uk-input uk-button-primary" type="submit" name = "submit" id="loginSubmit" value="versturen">
        </div>
    </div>


    </div>
</form>
</body>
';
require_once('scripts/footer.php');

/* ga verder met date veld doe dit in php !!!!!!!!!!!!!!!!!






/
