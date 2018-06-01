<?php
session_start();
include('database-connect.php');

if(isset($_POST['submit'])){
    insertItem($dbh);
}

function lastId($queryID) {
    sqlsrv_next_result($queryID);
    sqlsrv_fetch($queryID);
    return sqlsrv_get_field($queryID, 1);
}

function insertItem($dbh)
{
    $rubrieknr = $_GET['Rubrieknr'];
    $titel = $_POST['Titel'];
    $startprijs = $_POST['Startprijs'];
    $verzendkosten = $_POST['Verzendkosten'];
    $betalingswijze = $_POST['Betalingswijze'];
    $veilingtijd =  $_POST['Veilingtijd'];
    $image =  $_POST['Image'];
    $beschrijving = $_POST['Beschrijving'];
    $plaatsnaam = 'TestlandTim';
    $land = 'TestlandTim';
    $verkoper = $_SESSION['username'];

    try {
        $sql = "insert into
 voorwerp(  [titel]
           ,[beschrijving]
           ,[startprijs]
           ,[betalingswijze]
           ,[betalingsinstructie]
           ,[plaatsnaam]
           ,[land]
           ,[looptijd]
           ,[verzendkosten]
           ,[verzendinstructies]
           ,[verkoper])
        values (?,?,?,?,?,?,?,?,?,?,?)";

        $query = $dbh->prepare($sql);
        $query->execute(array($titel, $beschrijving, $startprijs, $betalingswijze,'Na betaling wordt het product verzonden.', $plaatsnaam, $land, $veilingtijd, $verzendkosten, 'test', $verkoper));
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }

    try{
        $sql = "select IDENT_CURRENT('Voorwerp') as ID";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        while ($results = $stmt->fetch()) {
            $lastInsertedId =  $results['ID'];
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }


    try {
        $sql = "insert into VoorwerpInRubriek ([voorwerp],[rubriek_op_laagste_Niveau])
        values (?,?)";

        $query = $dbh->prepare($sql);
        $query->execute(array($lastInsertedId, $rubrieknr));
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        die();
        header('Location: errorpage.php?err=500');
    }
}
