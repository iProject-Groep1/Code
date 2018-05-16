<?php
include('database-connect.php');


function login($dbh)
{
    //hashing van het wachtwoord moet nog
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];


    try {
        $sql = $dbh ->prepare("SELECT wachtwoord FROM gebruiker WHERE gebruikersnaam = :gebruikersnaam");
        if ($sql == false) {
            echo 'Failed to prepare statement';
        }

        $sql->bindParam(':gebruikersnaam', $gebruikersnaam);
        $sql->execute();
        $user = $sql->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    if (is_array($user)) {

        if (isset($_POST["wachtwoord"]) && isset($_POST["gebruikersnaam"]) && password_verify($wachtwoord, $user['wachtwoord'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = timeLogged();
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            return true;

        } else {
            header("Location: login.php");
            echo "Uw inloggegevens kloppen helaas niet.";
            return false;
        }
    } else {
        header("Location: login.php");
        echo "Uw inloggegevens kloppen helaas niet.";
        return false;
    }
}

/*  Deze functie checkt of je nog in de session bent.
   Dit gebeurd op iedere pagina opnieuw zodat hij weet ofdat de user nog in de session zit.*/
function CheckLogin ()
{
    if (isset($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}



function timeLogged () {

    $time = time();
    // 7 days; 24 hours; 60 mins; 60 secs
    return date('d-m-Y  G:i', $time);


}

?>