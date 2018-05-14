<?php
session_start();
include('database-connect.php');


/* ALLE INLOG PAGINA FUNCTIES */
/* Deze 2 if statements zorgen ervoor dat er gecheckt wordt of er gesubmit is.
 Indien een van de 2 forms ingevuld is start hij een functie. */
if(isset($_POST["submit"])) {
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
    $subject = 'Signup | Verification'; // Give the email a subject
    $message = '
 
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below.
 
------------------------
Email: ' . $email . '
Verification Code: ' . $hash . '
------------------------
 
Please click this link to activate your account:
http://iproject1.icasites.nl/verification.php?email='.$email.'&hash='.$hash.''; // Our message above including the link


    $headers = 'From:noreply@EenmaalAndermaal.com' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email
}



function verifyEmail($hash, $dbh){

    try {
        $sql = $dbh() ->prepare("SELECT hash FROM users WHERE hash = :hash");
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