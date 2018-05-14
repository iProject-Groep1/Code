<?php
require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country');

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
}

$search = ("SELECT email, hash FROM Verificatie WHERE email='".$email."' AND hash='".$hash."'");
$match  = mssql_num_rows($search);

if($match > 0){
    echo "Account geactiveerd";
}else{
    echo "invalid url or account has already been activated.";
}

echo $match;


?>
<body>
  <form>
    <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="<? $hach ?>">
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="<? $email ?>">
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
