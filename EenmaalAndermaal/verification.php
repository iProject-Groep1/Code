<?php

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
}

$search = ("SELECT email, hash FROM Verificatie WHERE email='".$email."' AND hash='".$hash."'");
$match  = mssql_num_rows($search);

if($match > 0){
    echo "Account geactiveerd";
}else{
    echo "invalid url or account has already been activated.";
}


echo $match;