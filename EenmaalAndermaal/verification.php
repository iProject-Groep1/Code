<?php
require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country.php');
include('scripts/database-connect.php');

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
    echo "Er ging iets mis";
}

}

echo'
<body>
<form>
    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-margin-auto uk-margin-top uk-margin-bottom">
      <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>
    <div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input" type="text" placeholder="gebruikersnaam">
        </div>
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="voornaam">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="achternaam">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Eerste adres">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Twede adres">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Postcode">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Plaatsnaam">
    </div>
    <div class="uk-margin">
        <select class="uk-select">
        ';
        Get_country($dbh);
        echo' </select>
    </div>
    geboortedag
    <div class="uk-margin">
        <div class="uk-inline">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input class="uk-input" type="text" placeholder="wachtwoord">
        </div>
    </div>
    vraag
    antwoord text
    
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>

    </div>
</form>
</body>
';
require_once('scripts/footer.php');
