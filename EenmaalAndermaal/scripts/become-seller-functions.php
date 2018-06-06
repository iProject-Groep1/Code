<?php
require_once('database-connect.php');
require_once('forgot-password-functions.php');
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submitVerification'])) {
    $verificationCodeCorrect = false;
    try {
        $stmt = $dbh->prepare("SELECT COUNT(gebruikersnaam) AS aantal FROM verkoper WHERE gebruikersnaam LIKE :gebruikersnaam AND verificatiecode LIKE :verificatiecode");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->bindValue(":verificatiecode", $_POST['verificationCode'], PDO::PARAM_STR);
        $stmt->execute();
        if($result = $stmt->fetch()){
            if($result['aantal'] != 1){
                $verificationCodeCorrect = false;
            } else {
                $verificationCodeCorrect = true;
            }
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    if($verificationCodeCorrect){
        try {
            $stmt = $dbh->prepare("UPDATE Gebruiker SET verkoper = 1 WHERE gebruikersnaam LIKE :gebruikersnaam");
            $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['profileNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: mail"></span> U bent nu verkoper!\', status: \'success\'})</script>';
            header('Location: ../profile.php');
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
            header('Location: ../errorpage.php?err=500');
        }


    } else {
        $_SESSION['becomeSellerFormNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \' < span uk - icon = "icon: close" ></span > Deze code klopt niet . \', status: \'danger\'})</script>';
        header('Location: ../become-seller.php?verification=1');
    }
}

if (isset($_POST['submit'])) {
    $passwordCorrect = false;
    $emailAdress = "";
    try {
        $stmt = $dbh->prepare("SELECT wachtwoord, mail_adres FROM gebruiker WHERE gebruikersnaam LIKE :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        if ($result = $stmt->fetch()) {
            $emailAdress = $result['mail_adres'];
            if (password_verify($_POST['password'], $result['wachtwoord'])) {
                $passwordCorrect = true;
            } else {
                $_SESSION['becomeSellerFormNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> Dit wachtwoord klopt niet.\', status: \'danger\'})</script>';
                header('Location: ../become-seller.php');
            };
        }
    } catch (PDOException $e) {
        echo "Fout bij ophalen wachtwoord" . $e->getMessage();
    }

    $verificationMethod = $_POST['verificationMethod'];
    $dataCorrect = false;

    if ($verificationMethod == "Creditcard") {
        if (empty($_POST['creditCardNumber']) || !isset($_POST['creditCardNumber'])) {
            $dataCorrect = false;
            $_SESSION['becomeSellerFormNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: creditcard"></span> U moet een creditcardnummer invullen.\', status: \'danger\'})</script>';

            if(empty($_POST['bankAccountNumber'])){
                $_POST['bankAccountNumber'] = NULL;
            }
        } else if (!empty($_POST['paymentMethod']) && isset($_POST['paymentMethod'])) {
            $dataCorrect = true;
        }
    } else if ($verificationMethod = "Post") {
        if (!empty($_POST['bankAccountNumber']) && isset($_POST['bankAccountNumber'])) {
            if(empty($_POST['creditCardNumber'])){
                $_POST['creditCardNumber'] = NULL;
            }
            $dataCorrect = true;
        } else {
            $dataCorrect = false;
            $_SESSION['becomeSellerFormNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: creditcard"></span> U moet een bankrekeningnummer invullen\', status: \'danger\'})</script>';
        }
    }

    if ($dataCorrect) {
        //TODO: functienaam aanpassen?
        $verificationCode = randomPassword(10);
        //zet alle data in verkopertabel
        try {
            //TODO: ja dit kan beter een arraytje worden want nu is het wel erg veel regels code terwijl dat eigenlijk niet hoeft doei
            $stmt = $dbh->prepare("INSERT INTO Verkoper VALUES(:gebruikersnaam, :betaalwijze, :rekeningnummer, :controleOptie, :creditcardnummer, :verificatiecode, 50)");
            $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
            $stmt->bindValue(":betaalwijze", $_POST['paymentMethod'], PDO::PARAM_STR);
            $stmt->bindValue(":rekeningnummer", $_POST['bankAccountNumber'], PDO::PARAM_STR);
            $stmt->bindValue(":controleOptie", $_POST['verificationMethod'], PDO::PARAM_STR);
            $stmt->bindValue(":creditcardnummer", $_POST['creditCardNumber'], PDO::PARAM_STR);
            $stmt->bindValue(":verificatiecode", $verificationCode, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Fout bij insert" . $e->getMessage();
            header('Location: ../errorpage.php?err=500');
        }
        //maak meteen verkoper als creditcardverificatie is gebruikt
        if ($verificationMethod == "Creditcard") {
            try {
                $stmt = $dbh->prepare("UPDATE Gebruiker SET verkoper = 1 WHERE gebruikersnaam LIKE :gebruikersnaam");
                $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
                die();
                header('Location: ../errorpage.php?err=500');
            }
        }
        createVerificationMail($emailAdress, $verificationMethod, $verificationCode);

        $_SESSION['profileNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: mail"></span> Er wordt zo snel mogelijk contact met u opgenomen.\', status: \'success\'})</script>';
        header('Location: ../profile.php');
    }
} else {
    header('Location: ../become-seller.php');
}

function createVerificationMail($email, $verificationMethod, $verificationCode = "kaas")
{

    $to = $email; // Send email to our user
    $subject = 'Verkoper worden | EenmaalAndermaal | I-Project Groep 1'; // Give the email a subject
    $message = '
 <!DOCTYPE HTML>
 <html lang="nl">
 <head>
 <meta charset="UTF-8">
</head>
<body>
<h1>Bedankt dat u verkoper wil worden op onze veilingsite.</h1>
<div>';
    if ($verificationMethod == "Creditcard") {
        $message .= '<p>We hebben uw gegevens geverifiëerd bij uw maatschappij en deze komen overeen.</p>
                    <h2>U bent nu een verkoper!</h2>';
    } else if ($verificationMethod == "Post") {
        $message .= '<p>Uw verificatiecode is: ' . $verificationCode . ', vul deze in op <a href="http://iproject1.icasites.nl/become-seller.php?verification=1">deze</a> pagina.</p> ';
    }


    $message .= '
<div>
<p>I-Project Groep 1</p>
</div>
</body>
</html>
'; // Our message above including the link

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email
}


function getPaymentMethodList($dbh)
{
    $paymentMethodList = '';
    try {
        $stmt = $dbh->prepare("SELECT Betaalwijze FROM Betaalwijze"); /* prepared statement */
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $paymentMethodList .= '<option value="' . $row['Betaalwijze'] . '">' . $row['Betaalwijze'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    return $paymentMethodList;
}