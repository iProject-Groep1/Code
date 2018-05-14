<?php
if (isset($_POST['username'])) {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        if(empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
            header('Location: ../login.php?notify=0');
        } else if(!empty(trim($_POST['username'])) && empty(trim($_POST['password']))){
            $url =  'login.php?notify=1&username='.$_POST['username'];
            header('Location:'.$url);
        } else{
            header('Location: ../login.php?notify=2');
        }
        die();
    } else {
        require_once('database-connect.php');
        $data = $dbh->query("SELECT wachtwoord FROM Gebruiker WHERE gebruikersnaam = '$_POST[username]'");
        $row = $data->fetch();
        if (!password_verify($_POST['password'], $row['wachtwoord'])) {
            header('Location: ../login.php?notify=3');
            die();

        } else {
            $_SESSION['username'] = $_POST['username'];
            header($_SESSION['lastVisited']);
            die();
        }


    }
}