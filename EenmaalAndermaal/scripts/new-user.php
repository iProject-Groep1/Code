<?php
include('database-connect.php');

if (isset($_POST['submit'])) {
    registerUser($dbh);
}

function registerUser($dbh)
{
    $passwordCorrect = false;
    $passwordContainsNumbers = false;
    $usernameCorrect = false;

    $firstname = $_POST['Voornaam'];
    $lastname = $_POST['Achternaam'];
    $firstAddress = $_POST['EersteAdres'];
    $secondAddress = $_POST['TweedeAdres'];
    $postcode = $_POST['Postcode'];
    $plaatsnaam = $_POST['Plaatsnaam'];
    $country = $_POST['Land'];
    //TODO: kan er een foutieve datum worden ingevuld???
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

        if ($row = $sql->fetch()) {
            if ($row['aantal'] != 0) {
                $usernameCorrect = false;
            } else {
                $usernameCorrect = true;
            }
        }

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }


    if ($passwordCorrect && $usernameCorrect) {
        sanitizing_input($username, $firstname, $lastname, $firstAddress, $secondAddress, $postcode, $plaatsnaam, $securityQuestionAnswer, $email, $dbh);

        try {
            $sql = "insert into Gebruiker ([gebruikersnaam], [voornaam], [achternaam], [adresregel1], [adresregel2], [postcode], [plaatsnaam], [land], [geboortedag], [mail_adres], [wachtwoord], [vraag], [antwoordtekst])
        values (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?)";
            $query = $dbh->prepare($sql);
            $query->execute(array($username, $firstname, $lastname, $firstAddress, $secondAddress, $postcode, $plaatsnaam, $country, $birthDate, $email, $passwordhash, $securityQuestion, $securityQuestionAnswer));
        } catch (PDOException $e){
            echo "Fout" . $e->getMessage();
            header('Location: errorpage.php?err=500');
        }

        try {
            $stmt = $dbh->prepare("delete from Verificatie where email like :email");
            $stmt->bindValue(":email", "%$email%", PDO::PARAM_STR);
            $stmt->execute();
        } catch(PDOException $e){
            echo "Fout" . $e->getMessage();
            header('Location: errorpage.php?err=500');
        }

        $_SESSION['regMelding'] = '
    <script>UIkit.notification({message: \'Bedankt voor de registratie ' . $username . '!\', status: \'success\'})</script>
    ';

        //TODO: METEEN INLOGGEN
        header('Location: ../login.php?username='.$username);

    } else {
        $headerURL = "Location: ../verification.php?email=" . $_POST['email'] . "&hash=" . $_POST['hash'] . '&firstname=' . $firstname . '&lastname=' . $lastname . '&firstAddress=' . $firstAddress . '&secondAddress=' . $secondAddress . '&postalCode=' . $postcode . '&city=' . $plaatsnaam . '&birthDate=' . $birthDate . '&username=' . $username . '&securityQuestionAnswer=' . $securityQuestionAnswer;
        if (!$usernameCorrect) {
            $headerURL .= '&usernameError=1';
        }
        if (!$passwordCorrect) {
            $headerURL .= '&passwordError=1';
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
