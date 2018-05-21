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
            //TODO: uikit script melding, dan kan deze check weg bij verificatie

        } else {
            //TODO: als testen klaar is dit verplaatsen in de try zodat alleen een mail verstuurd wordt wanneer email klopt en geïnsert is.
            $hash = md5(rand(0, 1000));
            createMessage($email, $hash);

            try {
                $sql = "INSERT INTO Verificatie(email, hash, isGeactiveerd) VALUES(?,?,?)"; /* prepared statement */
                $query = $dbh->prepare($sql);
                $query->execute(array($email, $hash, $isGeactiveerd));
                $_SESSION['regSucceedMelding'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span> De email is gestuurd naar: ' . $email . ' \', status: \'success\'})</script>';
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
                $_SESSION['emailMelding'] = '
                <script style="border-radius: 25px;">UIkit.notification({message: \' <span uk-icon="icon: warning"></span> Deze email heeft al een code ontvangen.\', status: \'danger\'})</script>';
                header('Location:../registration.php');
            }
        }
        header('Location: ../registration.php');
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


?>
