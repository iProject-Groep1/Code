<?php
include('database-connect.php');
session_start();
$username = $_SESSION['username'];
$password = $_POST['password'];
$newMail = $_POST['newMail'];

if (empty($password) || empty($newMail)) {
    header('Location: ../changeProfile.php?');
    $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Er zijn geen gegevens veranderd.\', status: \'danger\'})</script>';
} else if(!filter_var("$newMail", FILTER_VALIDATE_EMAIL)) {
    header('Location: ../changeProfile.php?');
    $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Geen geldig e-mailadres.\', status: \'danger\'})</script>';
}else{
   try {
       $stmt = $dbh->prepare("SELECT wachtwoord FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam");
       $stmt->bindValue(":gebruikersnaam", $username, PDO::PARAM_STR);
       $stmt->execute();
       $row = $stmt->fetch();
    }catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    if (!password_verify($password, $row['wachtwoord'])) {
        header('Location: ../changeProfile.php?');
        $_SESSION['noChance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Wachtwoord is incorrect.\', status: \'danger\'})</script>';
    }else{
        try{
            $sql = "UPDATE Gebruiker SET mail_adres = '$newMail' WHERE gebruikersnaam = '$username'";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            header('Location: ../profile.php?');
            $_SESSION['chance'] = '
            <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw e-mailadres is gewijzigd.\', status: \'success\'})</script>';
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
            header('Location: errorpage.php?err=500');
        }
   }
}