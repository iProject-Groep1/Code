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

//        $a = array_map('strval', $results);
//
//        if (count($results) == 0) {
//            $id = $id++;
//        } else {
//            $results = implode(",", $results);
//            return $results;
//        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}

function checkNumbers($dbh)
{
    $results = "";
    try {
        $stmt = $dbh->query("SELECT Voorwerpnummer FROM Voorwerp v WHERE v.Voorwerpnummer IS NOT NULL AND v.Veilinggesloten = 0"); /* prepared statement */

        while ($row = $stmt->fetch()) {
            createItem($dbh, $row['Voorwerpnummer']);
            echo "<br>";

        }

        return $results;

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


//    foreach($AllItems as $item) {
//        echo $item;
//        createItem($dbh, $item);
//        echo "<br>";
//    }


function getAuctionTitel($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT Titel FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
//        $results = $stmt->fetch(PDO::FETCH_ASSOC); /* fetcht de data, hij haalt de gevraagde data op niet 0,1,2etc. maar title, duration etc.*/
        while ($results = $stmt->fetch()) {
            $row = $results['Titel'];
        }
        return $row;

//        $a = array_map('strval', $results);

//        if (count($results) == 0) {
//            $id = $id++;
//        } else {
//            $results = implode(",", $results);
//            return $results;
//        }
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

//        $a = array_map('strval', $results);

//        if (count($results) == 0) {
//            $id = $id++;
//        } else {
//            $results = implode(",", $results);
//            return $results;
//        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


//function checkNumbers($dbh) {
//    $results = "";
//    try {
//        $stmt = $dbh->query("SELECT Voorwerpnummer FROM Voorwerp v WHERE v.Voorwerpnummer IS NOT NULL"); /* prepared statement */
//
//        while($row = $stmt->fetch()){
//            $results .=  '<h3>'.$row['Voorwerpnummer'].'</h3><img src="" ';
//        }
//
//        return $results;
//
//    } catch (PDOException $e) {
//        echo "Fout" . $e->getMessage();
//    }
//}


function createItem($dbh, $id)
{
    createItemScript(getAuctionTitel($dbh, $id), calcAuctionTime($dbh, $id), getAuctionFilename($dbh, $id));
}





