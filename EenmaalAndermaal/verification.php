<?php
$pageTitle = 'Verificatie';
require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country.php');
include('scripts/database-connect.php');
include('scripts/question.php');


$match = 0;
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable

    $form = '
<body>
<<<<<<< HEAD
<form class = "uk-form-horizontal" action="scripts/newUser.php?email='.$email.'" method="post" >
    <div class="uk-card uk-card-default uk-card-body uk-width-1-3@m uk-margin-auto uk-margin-top uk-margin-bottom">
      <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>
';
?>

    <div class="uk-margin uk-form-horizontal">
        <label class="uk-form-label" for="Voornaam">Voornaam*: </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" placeholder="Voornaam" name="Voornaam"required>
        </div>
    </div>

    <div class="uk-margin uk-form-horizontal">
        <div class="uk-form-controls">
            <input class="uk-input" type="text" placeholder="Achternaam" name="Achternaam"required>
        </div>
    </div>

    <div class="uk-margin uk-form-horizontal">
        <div class="uk-form-controls">
            <input class="uk-input" type="text" placeholder="Eerste adres" name="EersteAdres"required>
        </div>
=======
<form action="scripts/newUser.php?email=' . $email . '" method="post" >
        
    <div class="uk-card uk-card-default uk-card-body uk-width-1-3@m uk-margin-auto uk-margin-top uk-margin-bottom">
      <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>

    <input type="text" name="email" value="' . $_GET['email'] . '" hidden>
    <input type="text" name="hash" value="' . $_GET['hash'] . '" hidden>

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Voornaam" name="Voornaam"'; if(isset($_GET['firstname'])){$form .='value="'.$_GET['firstname'].'"';}
    $form.='required>
</div>

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Achternaam" name="Achternaam"'; if(isset($_GET['lastname'])){$form .='value="'.$_GET['lastname'].'"';}
    $form.='required>
</div>

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Eerste adres" name="EersteAdres"'; if(isset($_GET['firstAddress'])){$form .='value="'.$_GET['firstAddress'].'"';}
    $form.='required>
</div>

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Tweede adres (optioneel)" name="TweedeAdres"'; if(isset($_GET['secondAddress'])){$form .='value="'.$_GET['secondAddress'].'"';}
    $form.='>
</div>

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Postcode" name="Postcode"'; if(isset($_GET['postalCode'])){$form .='value="'.$_GET['postalCode'].'"';}
    $form.='required>
</div>

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Plaatsnaam" name="Plaatsnaam"'; if(isset($_GET['city'])){$form .='value="'.$_GET['city'].'"';}
    $form.='required>
</div>

<div class="uk-margin">
    <select class="uk-select" name="Land"required >
        <option value="Nederland">Nederland</option>
       ' .
        Get_country($dbh)
        . '
    </select>
</div>

<div class="uk-margin">
    <input class="uk-input" type="date" name="Datum"'; if(isset($_GET['birthDate'])){$form .='value="'.$_GET['birthDate'].'"';}
    $form.='required>
</div>';
    if(isset($_GET['usernameError']) && $_GET['usernameError'] == 1){$form.='<p class="uk-text-danger">Deze gebruikersnaam is al in gebruik.</p>';}

    $form.='
<div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input'; if(isset($_GET['usernameError']) && $_GET['usernameError'] == 1){$form.=' uk-form-danger';} $form.= '" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam" '; if(isset($_GET['username'])){$form .='value="'.$_GET['username'].'"';}
    $form.='required>
>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1
    </div>
</div>

<<<<<<< HEAD
    <div class="uk-margin uk-form-horizontal">
        <input class="uk-input" type="text" placeholder="Tweede adres" name="TweedeAdres">
=======
';
        if(isset($_GET['passwordError']) && $_GET['passwordError'] == 1){$form.='<p class="uk-text-danger">De opgegeven wachtwoorden komen niet overeen.</p>';}
$form.='
<div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
        <input class="uk-input'; if(isset($_GET['passwordError']) && $_GET['passwordError'] == 1){$form.=' uk-form-danger';} $form.= '" type="password" placeholder="Wachtwoord" name="Wachtwoord"required>
>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1
    </div>
</div>

<<<<<<< HEAD
    <div class="uk-margin uk-form-horizontal">
        <input class="uk-input" type="text" placeholder="Postcode" name="Postcode"required>
=======
<div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
        <input class="uk-input'; if(isset($_GET['passwordError']) && $_GET['passwordError'] == 1){$form.=' uk-form-danger';} $form.= '" type="password" placeholder="Wachtwoord bevestigen" name="Wachtwoord_bevestigen" required>
>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1
    </div>
</div>

<<<<<<< HEAD
    <div class="uk-margin uk-form-horizontal">
        <input class="uk-input" type="text" placeholder="Plaatsnaam" name="Plaatsnaam"required>
    </div>

    <div class="uk-margin uk-form-horizontal">
        <select class="uk-select" name="Land"required >
          <option value="Nederland">Nederland</option>
  <?php
        Get_country($dbh);
      ?>
        </select>
    </div>

    <div class="uk-margin uk-form-horizontal">
        <input class="uk-input" type="date" name="Datum"required>
=======
<div class="uk-margin">
    <select class="uk-select" name="vraag"required>' .
        Get_question($dbh) . '
    </select>
    <div class="uk-margin">

        <input class="uk-input" type="text" placeholder="Antwoord" name="Antwoord"'; if(isset($_GET['securityQuestionAnswer'])){$form .='value="'.$_GET['securityQuestionAnswer'].'"';}
    $form.='required>

>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1
    </div>
</div>

<<<<<<< HEAD
    <div class="uk-margin uk-form-horizontal">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam"required>
        </div>
    </div>

    <div class="uk-margin uk-form-horizontal">
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
            <input class="uk-input" type="password" placeholder="Wachtwoord" name="Wachtwoord" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        </div>
=======
<div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <input class="uk-input uk-button-primary" type="submit" name = "submit"  value="versturen">
>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1
    </div>
</div>

<<<<<<< HEAD
    <div class="uk-margin uk-form-horizontal">
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
            <input class="uk-input" type="password" placeholder="Wachtwoord bevestigen"  required>
        </div>
    </div>

    <div class="uk-margin uk-form-horizontal">
        <select class="uk-select" name="vraag"required>
        <?php
        Get_question($dbh);
        ?>
      </select>
        <div class="uk-margin uk-form-horizontal">
=======

</div>
</form>
</body>';
>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1

    echo $form;

} else {
    //TODO: uikit script melding: je kan alleen op deze pagina komen via de registratie-email
    header('Location: registration.php');
}

<<<<<<< HEAD
    <div class="uk-margin uk-form-horizontal">
        <div class="uk-inline uk-width-1-1">
            <input class="uk-input uk-button-primary" type="submit" name = "submit"  value="versturen">
        </div>
    </div>
=======
//$search = $dbh->query("SELECT email, hash FROM Verificatie WHERE email='" . $email . "' AND hash='" . $hash . "'");
//while ($row = $search->fetch()) {
//    $match ++;
//}
//
//if ($match > 0){
//
//    $dbh->query("UPDATE Verificatie SET isGeactiveerd='1' WHERE email='" . $email . "' AND hash='" . $hash . "'");
//}
>>>>>>> 351533b65767e9420951e3dc06e0f300275aa2f1


require_once('scripts/footer.php');

