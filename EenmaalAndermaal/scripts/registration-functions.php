<?php
session_start();
include('database-connect.php');


/* ALLE INLOG PAGINA FUNCTIES */
/* Deze 2 if statements zorgen ervoor dat er gecheckt wordt of er gesubmit is.
 Indien een van de 2 forms ingevuld is start hij een functie. */
if (isset($_POST["submit"])) {
    emailReg($dbh);
}


function emailReg($dbh)
{
    $email = $_POST['email'];
    $isGeactiveerd = 0;

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = 'The email you have entered is invalid, please try again.';
        } else {
            $msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.';
            $hash = md5(rand(0, 1000));
            createMessage($email, $hash);

            try {
                $sql = "INSERT INTO Verificatie(email, hash, isGeactiveerd) VALUES(?,?,?)"; /* prepared statement */
                $query = $dbh->prepare($sql);
                $query->execute(array($email, $hash, $isGeactiveerd));
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
            }
        }
        header('verification.php');
        echo $msg;
    }
}


function createMessage($email, $hash)
{
    $to = $email; // Send email to our user
    $subject = 'Registratie | Verificatie EenmaalAndermaal'; // Give the email a subject
    $message = '
 <!DOCTYPE HTML>
 <html lang="nl">
 <head>
 <meta charset="UTF-8">
</head>
<body>
<h1>Bedankt voor het registreren!</h1>
<div>
<p>Je account is gemaakt, nadat je gegevens hebt ingevuld kan je inloggen op <a href="http://iproject1.icasites.nl/login.php">EenmaalAndermaal</a></p>
<p>Klik op <a href="http://iproject1.icasites.nl/verification.php?email=' . $email . '&hash=' . $hash . '">deze link</a> om je gegevens in te vullen.</p>
 </div>

<div>
<p>Uw account is gemaakt met het volgende e-mail adres: ' . $email . '</p>
<p>Uw verificatie code is: ' . $hash . '</p>
</div>


</body>
</html>
'; // Our message above including the link

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email
}


function verifyEmail($hash, $dbh)
{

    try {
        $sql = $dbh()->prepare("SELECT hash FROM users WHERE hash = :hash");
        if ($sql == false) {
            echo 'Failed to prepare statement';
        }

        $sql->bindParam(':hash', $hash);
        $sql->execute();
        $user = $sql->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    if (is_array($user)) {

        if (isset($_POST["email"]) && isset($_POST["hash"]) && password_verify($hash, $user['hash'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = timeLogged();
            return true;

        } else {
            header("Location: login.php");

            // Create een message die verteld dat de inloggegevens niet kloppen.
            $_SESSION['messages'][] = 'Uw inloggegevens kloppen helaas niet.';
            return false;
        }
    } else {
        header("Location: login.php");
        $_SESSION['messages'][] = 'Uw inloggegevens kloppen helaas niet.';
        return false;
    }
}


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
