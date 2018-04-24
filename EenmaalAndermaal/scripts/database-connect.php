<?php
/*maakt connectie met de database*/
    $hostname = "mssql.iproject.icasites.nl"; //Naam van de Server
    $dbname = "iproject1";    //Naam van de Database
    $username = "iproject1";      //Inlognaam
    $pw = "JaaK8kbQ8S";      //Wachtwoord

    $dbh = new PDO ("sqlsrv:Server=$hostname;Database=$dbname;ConnectionPooling=0", "$username", "$pw");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>
