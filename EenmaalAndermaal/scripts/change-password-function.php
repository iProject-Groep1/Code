<?php
include('database-connect.php');
session_start();
$username = $_SESSION['username'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];
$passwordConfirmCorrect = false;
$passwordCorrect = false;
$passwordHash = "";

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {

    if (empty(trim($currentPassword)) || empty(trim($newPassword)) || empty(trim($confirmPassword))) {
        $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw wachtwoord is niet gewijzigd.\', status: \'danger\'})</script>';
        header('Location: ../change-password.php?');
    } else {
//controleert of wachtwoorden overeen komen.
        if ($newPassword != $confirmPassword) {
            $passwordConfirmCorrect = false;
        } else {
            $passwordConfirmCorrect = true;
            $passwordhash = password_hash($newPassword, PASSWORD_DEFAULT);
        }

//controleert of huidige wachtwoord correct is.
        try {
            $stmt = $dbh->prepare("SELECT wachtwoord FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam");
            $stmt->bindValue(":gebruikersnaam", $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if (!password_verify($currentPassword, $row['wachtwoord'])) {
                $passwordCorrect = false;
            } else {
                $passwordCorrect = true;
            }
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
            header('Location: errorpage.php?err=500');
        }

        if ($passwordConfirmCorrect & $passwordCorrect) {
            $stmt = $dbh->prepare("UPDATE Gebruiker SET wachtwoord = :wachtwoord WHERE gebruikersnaam = :gebruikersnaam");
            $stmt->bindValue(":wachtwoord", $passwordhash, PDO::PARAM_STR);
            $stmt->bindValue(":gebruikersnaam", $username, PDO::PARAM_STR);
            $stmt->execute();
            header('Location: ../profile.php?');
            $_SESSION['chance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw wachtwoord is gewijzigd.\', status: \'success\'})</script>';
        } else if (!$passwordConfirmCorrect & !$passwordCorrect) {
            header('Location: ../change-password.php?');
            $_SESSION['noChance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw huidige wachtwoord is incorrect en wachtwoorden komen niet overeen\', status: \'danger\'})</script>';
        } else if (!$passwordCorrect) {
            header('Location: ../change-password.php?');
            $_SESSION['noChance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw huidige wachtwoord is incorrect\', status: \'danger\'})</script>';
        } else if (!$passwordConfirmCorrect) {
            header('Location: ../change-password.php?');
            $_SESSION['noChance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Wachtwoorden komen niet overeen\', status: \'danger\'})</script>';
        }

    }
}else{
    header('Location: errorpage.php?err=404');
}