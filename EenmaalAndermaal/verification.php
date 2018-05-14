<?php
include('scripts/database-connect.php');

activateAccount($dbh);

function activateAccount($dbh)
{
$match = 0;
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        // Verify data
        $email = $_GET['email']; // Set email variable
        $hash = $_GET['hash']; // Set hash variable
    }

    $search = $dbh->query("SELECT email, hash FROM Verificatie WHERE email='" . $email . "' AND hash='" . $hash . "'");

    while ($row = $search->fetch()) {
        $match ++;
    }

    if ($match > 0) {
        header('index.php');
        echo "Account geactiveerd";

    } else {
        echo "invalid url or account has already been activated.";
    }
}