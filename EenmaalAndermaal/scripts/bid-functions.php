<?php

function calcMinBid($dbh, $id){
    $minBod = 0;
    $highestBid = getHighestBid($dbh, $id);
    $minIncrement = 0.01;
    $increment = 0.50;
    $increment1 = 1.00;
    $increment2 = 5.00;
    $increment3 = 10.00;
    $increment4 = 50.00;

    if($highestBid < 1){
        $minBod = $highestBid + $minIncrement;
    } else if($highestBid < 49.99) {
        $minBod = $highestBid + $increment;
    } else if($highestBid < 499.99) {
        $minBod = $highestBid + $increment1;
    } else if($highestBid < 999.99) {
        $minBod = $highestBid + $increment2;
    } else if($highestBid < 4999.99) {
        $minBod = $highestBid + $increment3;
    } else if($highestBid > 5000) {
        $minBod = $highestBid + $increment4;
    }
    return $minBod;
}


function setOwnBid ($dbh, $id, $bod, $voorwerp){
    $bodbedrag = $bod;
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);

    if($bodbedrag > setMinBid ($dbh, $id)){
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