<?php
if (isset($_post['done'])){
  echo 'lala';
  registerUser($dbh);
}

function registerUser($dbh)
{

  echo 'deze shit werkt wel';

    if ($_POST['wachtwoord'] != $_POST['Wachtwoord_bevestigen']) {
        echo 'Wachtwoord komt niet overeen';
        return;
    }

    //Alle variabelen van de Form
    $firstname = $_POST['Voornaam'];
    $lastname = $_POST['Achternaam'];
    $EersteAdres = $_POST['EersteAdres'];
    $TweedeAdres = $_POST['TweedeAdres'];
    $Postcode = $_POST['Postcode'];
    $Plaatsnaam = $_POST['Plaatsnaam'];
    $country = $_POST['Land'];
    $birth = $_POST['Datum'];
    $username = $_POST['Gebruikersnaam'];
    $password = $_POST['Wachtwoord'];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_GET['email']) && !empty($_GET['email'])){
    $email = ($_GET['email']);
    };
    $vraag = $_POST['vraag'];
    $antwoord = $_POST['Antwoord'];

  echo 'deze shit werkt wel';



    try {


        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo("$email is a valid email address");
        } else {
            header("Location: login.php");
            $_SESSION['messages'][] = 'Dit email adress is niet correct. Vul een valide email is a.u.b .';
            exit ('Velden zijn hetzelfde');

        }


        /*  sanitizing_input($firstname, $lastname, $username,  $email);*/




        $sql = "insert into Gebruiker ([gebruikersnaam], [voornaam], [achternaam], [adresregel1], [adresregel2], [postcode], [plaatsnaam], [land], [geboortedag], [mail_adres], [wachtwoord], [vraag], [antwoordtekst], [verkoper])
        values (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
        $query = dbconnect()->prepare($sql);

        $query->execute(array($username,$firstname, $lastname,$EersteAdres,$TweedeAdres,$Postcode,$Plaatsnaam, $country, $birth,$email , $passwordhash ,$vraag,$antwoord, 0 ));

        echo 'deze shit werkt';



    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    header("Location: login.php");
    $_SESSION['messages'][] = "Bedankt voor uw registratie " . $firstname . "!";
}

function sanitizing_input($username, $firstname, $lastname, $EersteAdres, $TweedeAdres, $Postcode, $Plaatsnaam, $antwoord)
{
    trim($firstname);
    trim($lastname);
    ucfirst($firstname);
    ucfirst($lastname);
    htmlspecialchars($firstname);
    htmlspecialchars($lastname);
    htmlspecialchars($EersteAdres);
    htmlspecialchars($TweedeAdres);
    htmlspecialchars($Postcode);
    htmlspecialchars($Plaatsnaam);
    htmlspecialchars($antwoord);


    try {

        $sql = "SELECT username FROM Users WHERE username = :username";
        $sql = dbconnect()->prepare($sql);
        $sql->bindParam(':username', $username);
        $sql->execute();
        $username = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sql->rowCount() != 0) {
            header("Location: login.php");
            $_SESSION['messages'][] = 'Deze username is helaas al in gebruik';
            exit ('Velden zijn hetzelfde');
        }


        $sql = "SELECT email FROM Users WHERE email = :email";
        $sql = dbconnect()->prepare($sql);
        $sql->bindParam(':email', $email);
        $sql->execute();
        $email = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sql->rowCount() != 0) {
            header("Location: login.php");
            $_SESSION['messages'][] = 'Deze email is helaas al in gebruik';
            exit ('Velden zijn hetzelfde');

        }
    } catch
    (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}

 ?>
