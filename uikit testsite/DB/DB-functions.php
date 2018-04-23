<?php

function login_user($dbh, $username, $password)
{
    $statement = $dbh->prepare("SELECT user_name, firstname, lastname FROM Customer where customer_mail_address = :name and password = :pass ");
    $statement->execute(array(':name' => $username,
        ':pass' => $password));
    $result = $statement->fetch();

    if (!is_null($result)) {
        if (!is_null($result['user_name'])) {
            $_SESSION['user'] = $result['firstname'] . ' ' . $result['lastname'];
            $_SESSION['login_time'] = date("H:i");
            $_SESSION['login_date'] = date("d-m-Y");
            header("Location: success.php");
        }
    }
}