<?php
include('database-connect.php');

if (isset($_POST['submit'])) {
    registerUser($dbh);
}

function registerUser($dbh)
{
    $dataCorrect = false;
    $passwordCorrect = false;
    $usernameCorrect = false;
    $emailCorrect = false;
    $emailUniek = false;

    $firstname = $_POST['Voornaam'];
    $lastname = $_POST['Achternaam'];
    $firstAddress = $_POST['EersteAdres'];
    $secondAddress = $_POST['TweedeAdres'];
    $postcode = $_POST['Postcode'];
    $plaatsnaam = $_POST['Plaatsnaam'];
    $country = $_POST['Land'];
    $birthDate = $_POST['Datum'];
    $username = $_POST['Gebruikersnaam'];
    $password = "";
    $passwordHash = "";

    $securityQuestion = $_POST['vraag'];
    $securityQuestionAnswer = $_POST['Antwoord'];
    $email = $_POST['email'];

    //controleer of wachtwoorden overeen komen
    if ($_POST['Wachtwoord'] != $_POST['Wachtwoord_bevestigen']) {
        $passwordCorrect = false;
    } else {
        $passwordCorrect = true;
        $password = $password = $_POST['Wachtwoord'];
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    }

    try {
        //controleer of de gebruikersnaam nog niet bezet is
        $sql = "SELECT count(gebruikersnaam) AS aantal FROM Gebruiker WHERE gebruikersnaam = :username";
        $sql = $dbh->prepare($sql);
        $sql->bindParam(':username', $username);
        $sql->execute();
        $username = $sql->fetch(PDO::FETCH_ASSOC);

        if ($row = $sql->fetch()) {
            if ($row['aantal'] != 0) {
                $usernameCorrect = false;
                //TODO: script melding
            } else {
                $usernameCorrect = true;
            }
        }


        //controleer of de email nog niet bezet is
        $sql = "SELECT count(email) AS aantal FROM Gebruiker WHERE mail_adres = :email";
        $sql = $dbh->prepare($sql);
        $sql->bindParam(':email', $email);
        $sql->execute();
        $email = $sql->fetch(PDO::FETCH_ASSOC);

        if ($row = $sql->fetch()) {
            if ($row['aantal'] != 0) {
                //TODO: script melding
                $emailUniek = false;
            } else {
                $emailUniek = true;
            }
        }
    } catch
    (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    //controleer of het email wel geldig is
    try {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailCorrect = false;
            //TODO: script melding
        } else {
            if ($emailUniek) {
                $emailCorrect = true;
            }

        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    if ($passwordCorrect && $usernameCorrect && $emailCorrect) {
        $dataCorrect = true;
    }

    if ($dataCorrect) {


        sanitizing_input($username, $firstname, $lastname, $firstAddress, $secondAddress, $postcode, $plaatsnaam, $securityQuestionAnswer, $email, $dbh);

        $sql = "insert into Gebruiker ([gebruikersnaam], [voornaam], [achternaam], [adresregel1], [adresregel2], [postcode], [plaatsnaam], [land], [geboortedag], [mail_adres], [wachtwoord], [vraag], [antwoordtekst])
        values (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?)";
        $query = $dbh->prepare($sql);
        $query->execute(array($username, $firstname, $lastname, $firstAddress, $secondAddress, $postcode, $plaatsnaam, $country, $birthDate, $email, $passwordhash, $securityQuestion, $securityQuestionAnswer));


        $_SESSION['regMelding'] = '
    <script>UIkit.notification({message: \'Bedankt voor de registratie ' . $username . '!\', status: \'danger\'})</script>
    ';


        $_SESSION['messages'][] = "Bedankt voor uw registratie " . $firstname . "!";


        $_SESSION['messages'][] = "Bedankt voor uw registratie " . $firstname . "!";
        header("Location: ../login.php");

    } else {
        echo $username;
        die();
        $headerURL = "Location: ../verification.php?email=" . $_POST['email'] . "&hash=" . $_POST['hash'] . '&firstname=' . $firstname . '&lastname=' . $lastname . '&firstAddress=' . $firstAddress . '&secondAddress=' . $secondAddress . '&postalCode=' . $postcode . '&city=' . $plaatsnaam . '&birthDate=' . $birthDate . '&username=' . $username . '&securityQuestionAnswer=' . $securityQuestionAnswer;
        if (!$usernameCorrect) {
            $headerURL .= '&usernameError=1';
        }
        if (!$passwordCorrect) {
            $headerURL .= '&passwordError=1';
        }

        if (!$emailUniek || !$emailCorrect) {
            $emailError = 0;
            if (!$emailUniek) {
                $emailError = 1;
            }
            if (!$emailCorrect) {
                $emailError = 2;
            }
            $headerURL .= 'emailError=' . $emailError;
        }

        header($headerURL);
    }
}

function sanitizing_input($username, $firstname, $lastname, $eersteAdres, $tweedeAdres, $postcode, $plaatsnaam, $antwoord, $email, $dbh)
{
    $firstname = trim($firstname);
    $lastname = trim($lastname);
    $firstname = ucfirst($firstname);
    $lastname = ucfirst($lastname);
    $firstname = htmlspecialchars($firstname);
    $lastname = htmlspecialchars($lastname);
    $eersteAdres = htmlspecialchars($eersteAdres);
    $tweedeAdres = htmlspecialchars($tweedeAdres);
    $postcode = htmlspecialchars($postcode);
    $plaatsnaam = htmlspecialchars($plaatsnaam);
    $antwoord = htmlspecialchars($antwoord);


}

?>
