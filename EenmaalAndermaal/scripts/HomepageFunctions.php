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


function checkNumbers($dbh)
{
    $results = "";
    echo '
                <div class="uk-child-width-1-4@m uk-grid" uk-grid>';

    try {
        $stmt = $dbh->query("SELECT Voorwerpnummer FROM Voorwerp v WHERE v.Voorwerpnummer IS NOT NULL"); /* prepared statement */

        while ($row = $stmt->fetch()) {
            createItem($dbh, $row['Voorwerpnummer']);
            echo "<br>";

        }
        echo '</div>';
        return $results;

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


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


function getPopularItem($dbh)
{

    try {
        $stmt = $dbh->prepare("select top 4 voorwerp, count(voorwerp) as aantal   from BOD  group by voorwerp order by aantal desc"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            createItem($dbh, $results['voorwerp']);
        }
        return;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}

function getHightItem($dbh)
{
    try {
        $stmt = $dbh->prepare("SELECT top 8 voorwerp , max(Bodbedrag) as prijs from BOD group by voorwerp order by prijs desc"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            createItem($dbh, $results['voorwerp']);
        }
        return;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}





