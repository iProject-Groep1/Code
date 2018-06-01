<?php
include('database-connect.php');
session_start();
$username = $_SESSION['username'];
$oldMail = $_SESSION['oldMail'];
$password = $_POST['password'];
$newMail = $_POST['newMail'];

if (empty(trim($oldMail)) || empty(trim($password)) || empty(trim($newMail))) {
    header('Location: ../profile.php?');
    $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Er zijn geen gegevens veranderd.\', status: \'danger\'})</script>';
} else {
    $stmt = $dbh->prepare("SELECT wachtwoord FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam");
    $stmt->bindValue(":gebruikersnaam", $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if (!password_verify($_POST['password'], $row['wachtwoord'])) {
        $sql = "UPDATE Gebruiker SET mail_adres = '$newMail' WHERE gebruikersnaam = '$username'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        header('Location: ../profile.php?');
        $_SESSION['chance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw e-mailadres is gewijzigd.\', status: \'success\'})</script>';
    }
}