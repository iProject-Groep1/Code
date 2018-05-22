<?php
$pageTitle = 'Verificatie';
require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country.php');
include('scripts/database-connect.php');
include('scripts/question.php');


$validURL = false;
/*
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    //TODO CONTROLEER MET DATABASE
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable

    $sql = "SELECT COUNT(mail) AS aantal FROM Verificatie WHERE mail like '$email' AND hash like '$hash';
    $query = $dbh->prepare($query);
    $query->execute();
    if($query->fetch()){
    if($row['aantal'] == 1){
    $validURL = true;
    }
    }
*/
//}

//if($validURL){
    $form = '

<body>

<form action="scripts/newUser.php?email=' . $email . '" method="post" >
              <h3 class="uk-card-title uk-text-center uk-margin-bottom-remove">Registreren bij EenmaalAndermaal</h3>
    <div class="uk-card uk-card-default uk-card-body uk-width-2-5@m uk-margin-auto uk-margin-top-remove uk-margin-bottom">


    <input type="text" name="email" value="' . $_GET['email'] . '" hidden>
    <input type="text" name="hash" value="' . $_GET['hash'] . '" hidden>
<p class="uk-icon-font-awesome">* : Verplicht veld</p>
<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Voornaam* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Voornaam" name="Voornaam"'; if(isset($_GET['firstname'])){$form .='value="'.$_GET['firstname'].'"';}
    $form.='required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Achternaam">Achternaam* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Achternaam" name="Achternaam"'; if(isset($_GET['lastname'])){$form .='value="'.$_GET['lastname'].'"';}
    $form.='required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Eerste Adres* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Eerste adres" name="EersteAdres"'; if(isset($_GET['firstAddress'])){$form .='value="'.$_GET['firstAddress'].'"';}
    $form.='required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Tweede Adres :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Tweede adres (optioneel)" name="TweedeAdres"'; if(isset($_GET['secondAddress'])){$form .='value="'.$_GET['secondAddress'].'"';}
    $form.='>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Postcode* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Postcode" name="Postcode"'; if(isset($_GET['postalCode'])){$form .='value="'.$_GET['postalCode'].'"';}
    $form.='required>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Plaatsnaam* :</label>
    <input class="uk-input uk-width-2-3" type="text" placeholder="Plaatsnaam" name="Plaatsnaam"'; if(isset($_GET['city'])){$form .='value="'.$_GET['city'].'"';}
    $form.='required>
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
    <input class="uk-input uk-width-2-3" type="date" name="Datum"'; if(isset($_GET['birthDate'])){$form .='value="'.$_GET['birthDate'].'"';}
    $form.='required>
</div>';
    if(isset($_GET['usernameError']) && $_GET['usernameError'] == 1){$form.='<p class="uk-text-danger">Deze gebruikersnaam is al in gebruik.</p>';}

    $form.='
<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Gebruikersnaam* :</label>
    <div class="uk-inline uk-width-2-3">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input'; if(isset($_GET['usernameError']) && $_GET['usernameError'] == 1){$form.=' uk-form-danger';} $form.= '" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam" '; if(isset($_GET['username'])){$form .='value="'.$_GET['username'].'"';}
    $form.='required>

    </div>
</div>

';
        if(isset($_GET['passwordError']) && $_GET['passwordError'] == 1){$form.='<p class="uk-text-danger">De opgegeven wachtwoorden komen niet overeen.</p>';}
$form.='
<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Wachtwoord* :</label>
    <div class="uk-inline uk-width-2-3">
        <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
        <input class="uk-input'; if(isset($_GET['passwordError']) && $_GET['passwordError'] == 1){$form.=' uk-form-danger';} $form.= '" type="password" placeholder="Wachtwoord" name="Wachtwoord" pattern="(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
    </div>
</div>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Wachtwoord Bevestigen* :</label>
    <div class="uk-inline uk-width-2-3">
        <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
        <input class="uk-input'; if(isset($_GET['passwordError']) && $_GET['passwordError'] == 1){$form.=' uk-form-danger';} $form.= '" type="password" placeholder="Wachtwoord bevestigen" name="Wachtwoord_bevestigen" pattern="(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>

    </div>
</div>


<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Veiligheidsvraag* :</label>
    <select class="uk-select uk-width-2-3" name="vraag"required>' .
        Get_question($dbh) . '
    </select>
    <div class="uk-margin">
        <label class="uk-form-label uk-width-1-3 uk-margin-small-bottom" for="Voornaam">Antwoord* :</label>
        <input class="uk-input uk-width-2-3" type="text" placeholder="Antwoord" name="Antwoord"'; if(isset($_GET['securityQuestionAnswer'])){$form .='value="'.$_GET['securityQuestionAnswer'].'"';}
        $form.='required>
    </div>
</div>


<div class="uk-margin uk-flex uk-flex-center ">
    <div class="uk-inline uk-width-1-2">
        <input class="uk-input uk-button-primary" type="submit" name = "submit"  value="Versturen">
    </div>
</div>


</div>
</form>
</body>';

    echo $form;

//}
//else {
    //TODO: uikit script melding: je kan alleen op deze pagina komen via de registratie-email
$_SESSION['emailMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \' <span uk-icon="icon: warning"></span> Deze verificatielink is niet geldig.\', status: \'danger\'})</script>';
    //header('Location: registration.php');
//}





require_once('scripts/footer.php');

