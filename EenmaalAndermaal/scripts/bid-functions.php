<?php
include('homepage-functions.php');

function calcMinBid($dbh, $id){
    $minBod = 0;
    $minIncrement = 0.01;
    $increment = 0.50;
    $increment1 = 1.00;
    $increment2 = 5.00;
    $increment3 = 10.00;
    $increment4 = 50.00;

    if(getHighestBid($dbh, $id) < 1){
        $minBod = getHighestBid($dbh, $id) + $minIncrement;
    } else if(getHighestBid($dbh, $id) < 49.99) {
        $minBod = getHighestBid($dbh, $id) + $increment;
    } else if(getHighestBid($dbh, $id) < 499.99) {
        $minBod = getHighestBid($dbh, $id) + $increment1;
    } else if(getHighestBid($dbh, $id) < 999.99) {
        $minBod = getHighestBid($dbh, $id) + $increment2;
    } else if(getHighestBid($dbh, $id) < 4999.99) {
        $minBod = getHighestBid($dbh, $id) + $increment3;
    } else if(getHighestBid($dbh, $id) > 5000) {
        $minBod = getHighestBid($dbh, $id) + $increment4;
    }
    return $minBod;
}


function setMinBid ($dbh, $id, $voorwerp){
    $bodbedrag = calcMinBid($dbh, $id);
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);

    try {
        $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
        $query = $dbh->prepare($sql);
        $query->execute(array($voorwerp, $bodbedrag, $gebruiker, $bodtijd));
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


function setOwnBid ($dbh, $id, $bod, $voorwerp){
    $bodbedrag = $bod;
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);
    
    if($bodbedrag > setMinBid ($dbh, $id, $voorwerp)){
        try {
            $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?,?,?,?)"; /* prepared statement */
            $query = $dbh->prepare($sql);
            $query->execute(array($voorwerp, $bodbedrag, $gebruiker, $bodtijd));
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }
    } else {
        echo "Het bedrag is te weinig! Vul een groter bedrag in.";
    }

}



function getHighestBid($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT MAX(Bodbedrag) as Hoogstebod FROM Bod b WHERE b.Voorwerp = :Voorwerp"); /* prepared statement */
        $stmt->bindValue(":Voorwerp", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $row = $results['Hoogstebod'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}