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
    $emailUniekGebruiker = false;
    $emailUniekVerificatie = false;
    $emailCorrect = false;


    if (isset($_POST['email']) && !empty($_POST['email'])) {
        //controleer of het emailadres nog geen account heeft
        try {
            $sql = "SELECT count(mail_adres) AS aantal FROM Gebruiker WHERE mail_adres = :email";
            $sql = $dbh->prepare($sql);
            $sql->bindParam(':email', $email);
            $sql->execute();

            if ($row = $sql->fetch()) {
                if ($row['aantal'] != 0) {
                    $emailUniekGebruiker = false;
                } else {
                    $emailUniekGebruiker = true;
                }
            }
            echo "gebruikeremail";
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();

        }

        //controleer of het emailadres nog geen verificatiemail heeft
        try {
            $sql = "SELECT count(email) AS aantal FROM Verificatie WHERE email = :email";
            $sql = $dbh->prepare($sql);
            $sql->bindParam(':email', $email);
            $sql->execute();

            if ($row = $sql->fetch()) {
                if ($row['aantal'] != 0) {
                    $emailUniekVerificatie = false;
                } else {
                    $emailUniekVerificatie = true;
                }
            }
            echo "verificatie-email";
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }

        //controleer of het emailadres geldig is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "emailfilter fout";
            $emailCorrect = false;
        } else {
            echo "emailfilter goed";
            if ($emailUniekGebruiker && $emailUniekVerificatie) {
                $emailCorrect = true;
            }
        }

        echo "voor check";
        if ($emailCorrect && $emailUniekGebruiker && $emailUniekVerificatie) {
            echo "insert";
            try {
                $hash = md5(rand(0, 1000));
                createMessage($email, $hash);
                $sql = "INSERT INTO Verificatie(email, hash, isGeactiveerd) VALUES(?,?,?)"; /* prepared statement */
                $query = $dbh->prepare($sql);
                $query->execute(array($email, $hash, 0));
                $_SESSION['regSucceedMelding'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span> De email is gestuurd naar: ' . $email . ' \', status: \'success\'})</script>';
                header('Location: ../registration.php');
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
            }
        } else {
            echo "EMAIL NIET INSErT";
            if (!$emailCorrect) {
                $_SESSION['emailMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \' <span uk-icon="icon: warning"></span> Vul een geldig e-mailadres in.\', status: \'danger\'})</script>';
            }
            if (!$emailUniekGebruiker) {
                $_SESSION['emailMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \' <span uk-icon="icon: warning"></span> Er bestaat al een account met dit e-mailadres. <a href="login.php">Inloggen?</a>\', status: \'danger\'})</script>';
            }
            if (!$emailUniekVerificatie) {
                //TODO: als triggers zijn ingebouwd: "PROBEER HET NOG EEN KEER OVER .... MINUTEN".
                $_SESSION['emailMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \' <span uk-icon="icon: warning"></span> Dit e-mailadres heeft al een mail ontvangen.\', status: \'danger\'})</script>';
            }
            header('Location: ../registration.php');
        }
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
?>
