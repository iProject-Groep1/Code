<?php

require_once('database-connect.php');


//function checkAuctionStatus($dbh, $id)
//{
//    try {
//        $stmt = $dbh->prepare("SELECT Veilinggesloten FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
//        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
//        $stmt->execute(); /* stuurt alles naar de server */
//        $results = $stmt->fetch(PDO::FETCH_ASSOC); /* fetcht de data, hij haalt de gevraagde data op niet 0,1,2etc. maar title, duration etc.*/
//
//        $results = implode(",", $results);
//        return $results;
//    } catch (PDOException $e) {
//        echo "Fout" . $e->getMessage();
//    }
//
//}


function calcAuctionTime($dbh, $id)
{

    try {

        $stmt = $dbh->prepare("SELECT LooptijdEindMoment FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $row = $results['LooptijdEindMoment'];
        }
        return $row;

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
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


function getAuctionTitel($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT Titel FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $row = $results['Titel'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


function getAuctionFilename($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT Filenaam FROM Voorwerp v, Bestand b WHERE v.Voorwerpnummer = b.Voorwerp AND v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
//        $results = $stmt->fetch(PDO::FETCH_ASSOC); /* fetcht de data, hij haalt de gevraagde data op niet 0,1,2etc. maar title, duration etc.*/
        while ($results = $stmt->fetch()) {
            $row = $results['Filenaam'];
        }
        return $row;

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


function createItem($dbh, $id)
{
    createItemScript(getAuctionTitel($dbh, $id), calcAuctionTime($dbh, $id), getAuctionFilename($dbh, $id), getHighestBid($dbh, $id));
}





