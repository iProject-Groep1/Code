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
$email = $_GET['email'];

echo'
<body>
<<<<<<< HEAD
<<<<<<< HEAD

<form action="scripts/new-user.php?email=' . $email . '" method="post" >
              <h3 class="uk-card-title uk-text-center uk-margin-bottom-remove">Registreren bij EenmaalAndermaal</h3>
=======
<h3 class="uk-margin uk-card-title uk-text-center">Registreren bij EenmaalAndermaal</h3>
<form action="scripts/newUser.php?email=' . $email . '" method="post" >
>>>>>>> 9c199b119cb0c2cdf711e89a3b416edd9ee145ba
    <div class="uk-card uk-card-default uk-card-body uk-width-2-5@m uk-margin-auto uk-margin-top-remove uk-margin-bottom">
    <input type="text" name="email" value="' . $_GET['email'] . '" hidden>
    <input type="text" name="hash" value="' . $_GET['hash'] . '" hidden>
    <p class="uk-icon-font-awesome uk-margin-remove">* = Verplicht veld</p>
<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Voornaam* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Voornaam" name="Voornaam"';
    if (isset($_GET['firstname'])) {
        $form .= 'value="' . $_GET['firstname'] . '"';
    }
    $form .= 'required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Achternaam">Achternaam* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Achternaam" name="Achternaam"';
    if (isset($_GET['lastname'])) {
        $form .= 'value="' . $_GET['lastname'] . '"';
    }
    $form .= 'required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Eerste Adres* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Eerste adres" name="EersteAdres"';
    if (isset($_GET['firstAddress'])) {
        $form .= 'value="' . $_GET['firstAddress'] . '"';
    }
    $form .= 'required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Tweede Adres :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Tweede adres (optioneel)" name="TweedeAdres"';
    if (isset($_GET['secondAddress'])) {
        $form .= 'value="' . $_GET['secondAddress'] . '"';
    }
    $form .= '>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Postcode* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Postcode" name="Postcode"';
    if (isset($_GET['postalCode'])) {
        $form .= 'value="' . $_GET['postalCode'] . '"';
    }
    $form .= 'required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Plaatsnaam* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Plaatsnaam" name="Plaatsnaam"';
    if (isset($_GET['city'])) {
        $form .= 'value="' . $_GET['city'] . '"';
    }
    $form .= 'required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Land* :</label>
    <select class="uk-select uk-width-2-3" name="Land"required >
        <option value="Nederland">Nederland</option>
       ' .
        Get_country($dbh)
        . '
    </select>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Geboortedatum* :</label>
    <input class="uk-input uk-width-2-3" type="date" name="Datum"';
    if (isset($_GET['birthDate'])) {
        $form .= 'value="' . $_GET['birthDate'] . '"';
    }
    $form .= 'required>
</div>';
    if (isset($_GET['usernameError']) && $_GET['usernameError'] == 1) {
        $form .= '<p class="uk-text-danger">Deze gebruikersnaam is al in gebruik.</p>';
    }

    $form .= '
<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Gebruikersnaam* :</label>
    <div class="uk-inline uk-width-2-3">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input';
    if (isset($_GET['usernameError']) && $_GET['usernameError'] == 1) {
        $form .= ' uk-form-danger';
    }
    $form .= '" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam" ';
    if (isset($_GET['username'])) {
        $form .= 'value="' . $_GET['username'] . '"';
    }
    $form .= 'required>
=======
<form action="scripts/newUser.php?email='.$email.'" method="post" >
    <div class="uk-card uk-card-default uk-card-body uk-width-1-3@m uk-margin-auto uk-margin-top uk-margin-bottom">
      <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>
';
?>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Voornaam" name="Voornaam"required>
    </div>
>>>>>>> ae531bcc34fe862ba88da01106603c0eaea8255f

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Achternaam" name="Achternaam"required>
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Eerste adres" name="EersteAdres"required>
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Tweede adres" name="TweedeAdres">
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Postcode" name="Postcode"required>
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Plaatsnaam" name="Plaatsnaam"required>
    </div>

    <div class="uk-margin">
        <select class="uk-select" name="Land"required >
          <option value="Nederland">Nederland</option>
  <?php
        Get_country($dbh);
      ?>
        </select>
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="date" name="Datum"required>
    </div>

    <div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam"required>
        </div>
    </div>

    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
            <input class="uk-input" type="password" placeholder="Wachtwoord" name="Wachtwoord"required>
        </div>
    </div>

    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
            <input class="uk-input" type="password" placeholder="Wachtwoord_bevestigen"required>
        </div>
    </div>

    <div class="uk-margin">
        <select class="uk-select" name="vraag"required>
        <?php
        Get_question($dbh);
        ?>
      </select>
        <div class="uk-margin">

            <input class="uk-input" type="text" placeholder="Antwoord" name="Antwoord"required>

          </div>
    </div>

    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <input class="uk-input uk-button-primary" type="submit" name = "submit"  value="versturen">
        </div>
    </div>


    </div>
</form>
</body>
<?php
require_once('scripts/footer.php');
?>
