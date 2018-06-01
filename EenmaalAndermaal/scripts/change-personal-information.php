<?php
include('database-connect.php');
session_start();
$username = $_SESSION['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$adres1 = $_POST['adres1'];
$postalCode = $_POST['postalCode'];
$placeName = $_POST['placeName'];
$country = $_POST['country'];

//empty(trim($postalCode)) || empty(trim($placeName)) || empty(trim($country))
if (empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($birthday)) || empty(trim($adres1)) || empty(trim($postalCode)) || empty(trim($placeName)) || empty(trim($country))) {
    header('Location: ../profile.php?');
    $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Er zijn geen gegevens veranderd.\', status: \'danger\'})</script>';
} else {
    //postcode = '$postalCode', plaatsnaam = '$placeName', land = '$country'
    $sql = "UPDATE Gebruiker SET voornaam = '$firstname', achternaam= '$lastname', geboortedag = '$birthday', adresregel1 = '$adres1', postcode = '$postalCode', plaatsnaam = '$placeName', land = '$country' WHERE gebruikersnaam = '$username'";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    header('Location: ../profile.php?');
    $_SESSION['chance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw gegevens zijn veranderd.\', status: \'success\'})</script>';
}





