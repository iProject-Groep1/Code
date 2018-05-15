<?php
session_start();
include('database-connect.php');
include('bid-functions.php');
include('homepage-functions.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Verify data
    $id = $_GET['id']; // Set email variable
    setMinBid($dbh, $id);
}


function setMinBid ($dbh, $id){
    $bodbedrag = calcMinBid($dbh, $id);
//    $gebruiker = "Gekke henkie";
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);

    try {
        $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
        $query = $dbh->prepare($sql);
        $query->execute(array($id, $bodbedrag, $gebruiker, $bodtijd));
        echo "done";
        header("scripts/detailpage.php?id=' . $id . '");
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}