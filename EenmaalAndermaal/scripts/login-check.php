<?php
session_start();
$redirect = "";
if (isset($_SESSION['lastVisited'])) {
    $redirect = $_SESSION['lastVisited'];
    if (strpos($redirect, 'verification.php') !== false || strpos($redirect, 'registration.php') !== false || strpos($redirect, 'login.php') !== false || strpos($redirect, 'forgot-password.php') !== false) {
        $redirect = "../index.php";
    }
} else {
    $redirect = "../index.php";
}

if (isset($_POST['username'])) {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        if (empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
            header('Location: ../login.php?notify=0');
        } else if (!empty(trim($_POST['username'])) && empty(trim($_POST['password']))) {
            header('Location: ../login.php?notify=1&username=' . $_POST['username']);
        } else {
            header('Location: ../login.php?notify=2');
        }
    } else {
        require_once('database-connect.php');
        try {
            $stmt = $dbh->prepare("SELECT wachtwoord FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam");
            $stmt->bindValue(":gebruikersnaam", $_POST['username'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if (!password_verify($_POST['password'], $row['wachtwoord'])) {
                header('Location: ../login.php?notify=3&username=' . $_POST['username']);
            } else {
                $_SESSION['username'] = $_POST['username'];
                header('Location: ' . $redirect);
            }
        }catch (PDOException $e){
            echo "Fout" . $e->getMessage();
            header('Location: errorpage.php?err=500');
        }

    }
}