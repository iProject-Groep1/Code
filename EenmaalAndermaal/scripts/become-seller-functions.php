<?php
require_once('database-connect.php');
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submit'])) {
    $passwordCorrect = false;
    try {
        $stmt = $dbh->prepare("SELECT wachtwoord FROM gebruiker WHERE gebruikersnaam LIKE :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        if ($result = $stmt->fetch()) {
            if (password_verify($_POST['wachtwoord'], $result['wachtwoord'])) {
                $passwordCorrect = true;
            } else {
                $_SESSION['becomeSellerFormNotification'] = '<script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> Dit wachtwoord klopt niet.\', status: \'danger\'})</script>';
                header('Location: ../become-seller.php');
            };
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    if ($passwordCorrect) {
        
    }

}

function startVerification(){

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