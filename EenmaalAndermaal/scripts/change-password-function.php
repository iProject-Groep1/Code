<?php
include('database-connect.php');
session_start();
$username = htmlentities($_SESSION['username'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$currentPassword = htmlentities($_POST['currentPassword'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$newPassword = htmlentities($_POST['newPassword'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$confirmPassword = htmlentities($_POST['confirmPassword'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$passwordConfirmCorrect = false;
$passwordCorrect = false;
$passwordHash = "";

$pogingen = 3 - $_SESSION['Pogingen'];
echo $_SESSION['Pogingen'];

if($_SESSION['Pogingen'] >= 3) {
    session_unset();
    session_destroy();
    header('Location: ../login.php?');
    session_start();
    $_SESSION['safety'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Om veiligheidsredenen bent u uitgelogd. Wachtwoord vergeten? <a href="forgot-password.php"> Klik Hier </a>\', status: \'danger\'})</script>';
    die();
}

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
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw huidige wachtwoord is incorrect en wachtwoorden komen niet overeen. U kan nog '. $pogingen .' keer proberen\', status: \'danger\'})</script>';
        } else if (!$passwordCorrect) {
            header('Location: ../change-password.php?');
            $_SESSION['Pogingen'] ++;
            $_SESSION['noChance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw huidige wachtwoord is incorrect , u kan nog '. $pogingen .' keer proberen\', status: \'danger\'})</script>';
        } else if (!$passwordConfirmCorrect) {
            header('Location: ../change-password.php?');
            $_SESSION['Pogingen'] ++;
            $_SESSION['noChance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Wachtwoorden komen niet overeen\', status: \'danger\'})</script>';
        }

    }
}else{
    header('Location: errorpage.php?err=404');
}