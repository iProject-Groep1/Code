<?php
include('database-connect.php');
session_start();
$username = $_SESSION['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];

if (empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($birthday))) { //|| empty(trim($_POST['mobileNr']))
    header('Location: ../profile.php?');
    $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Er zijn geen gegevens veranderd.\', status: \'danger\'})</script>';
} else {
    $sql = "UPDATE Gebruiker SET voornaam = '$firstname', achternaam= '$lastname', geboortedag = '$birthday' WHERE gebruikersnaam = '$username'";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    header('Location: ../profile.php?');
    $_SESSION['chance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw gegevens zijn veranderd.\', status: \'success\'})</script>';
}





