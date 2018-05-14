<?php

require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country');
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
    echo "Account is geactiveerd";
    $dbh->query("UPDATE Verificatie SET isGeactiveerd='1' WHERE email='" . $email . "' AND hash='" . $hash . "'");
} else {
    echo "Er ging iets mis";
}

}

echo'<body>
<form>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder= .' $hash '.>
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder= .' $email'. >
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="gebruikersnaam">
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
            <?PHP Get_country($dbh) ?>
        </select>
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Input">
    </div>


</form>
</body>
';
