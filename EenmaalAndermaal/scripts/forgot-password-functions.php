<?php
include_once('database-connect.php');

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_POST['username'])) {
    if (usernameValid($_POST['username'], $dbh)) {
        header('Location: ../forgot-password.php?username=' . $_POST['username']);
    } else {
        header('Location: ../forgot-password.php');
    }
} else {
    header('Location ../errorpage.php?err=400');
}


if(isset($_POST['questionAnswer'])){
    try{
        $stmt = $dbh->prepare("SELECT count(gebruikersnaam) AS aantal FROM Gebruiker WHERE gebruikersnaam LIKE :username AND antwoordtekst LIKE :answer");
        $stmt->bindValue(":username", $_POST['hiddenUsername'], PDO::PARAM_STR);
        $stmt->bindValue(":answer", $_POST['questionAnswer'], PDO::PARAM_STR );
        $stmt->execute();
        if($results = $stmt->fetch()){
            if($results['aantal'] == 1){
                //stuur mail
                echo "ja het werkt";
            } else {
                $_SESSION['questionNotification'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> Dit antwoord is fout.\', status: \'danger\'})</script>';
                header('Location: ../forgot-password.php?username='.$_POST['username']);
            }
        }
    } catch(PDOException $e){
        echo "Error" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
} else {
    header('Location ../errorpage.php?err=400');
}



function usernameValid($username, $dbh)
{
    try {
        $stmt = $dbh->prepare("SELECT COUNT (gebruikersnaam) AS aantal FROM Gebruiker WHERE gebruikersnaam like :username");
        $stmt->bindValue("username", $username, PDO::PARAM_STR);
        $stmt->execute();
        if ($result = $stmt->fetch()) {
            if ($result['aantal'] == 1) {
                return true;
            } else {
                $_SESSION['forgotPasswordNotification'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: user"></span> Deze gebruikersnaam bestaat niet.\', status: \'danger\'})</script>';
                return false;
            }
        }
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
    return false;
}

//TODO: password generator
function sendNewPassword($email)
{
    $to = $email; // Send email to our user
    $subject = 'Herstel Uw Wachtwoord | EenmaalAndermaal | I-Project Groep 1'; // Give the email a subject
    $message = '
 <!DOCTYPE HTML>
 <html lang="nl">
 <head>
 <meta charset="UTF-8">
</head>
<body>
<h1>Uw nieuwe wachtwoord.</h1>
<div>
<p>U heeft zojuist een nieuw wachtwoord aangevraagd.</p>
<p>Uw nieuwe wachtwoord is: <span>...</span></p>
 </div>

<div>
<p>U kunt hiermee inloggen via <a href="iproject1.icasites.nl/login.php">deze</a> link</p>
<p>Heeft u dit wachtwoord niet aangevraagd? Neem dan zo snel mogelijk contact op met onze klantenservice.</p>

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
?>