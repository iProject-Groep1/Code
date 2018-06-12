<?php

require_once('database-connect.php');
//Deze functie vraagt de tijd van de database op. Deze tijd modified hij met +10 minuten.
function getServerTime($dbh)
{
    try {
        $stmt = $dbh->prepare("SELECT DISTINCT CURRENT_TIMESTAMP as Tijd FROM Voorwerp"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $row = $results['Tijd'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
}

//Deze functie vraagt het LooptijdEindmoment op uit de database. Door deze waarde kan de timer goed functioneren aangezien de timer weet wanneer hij klaar moet zijn
function getAuctionEnd($dbh, $id)
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
        header('Location: errorpage.php?err=500');
    }

}

// Deze functie vraagt de filename van het plaatje van de auction op. Deze wordt opgehaald uit de database.
function getAuctionFilename($dbh, $id)
{
    $array = [];
    try {
        $stmt = $dbh->prepare("SELECT Filenaam FROM Voorwerp v, Bestand b WHERE v.Voorwerpnummer = b.Voorwerp AND v.Voorwerpnummer = :Voorwerpnummer");
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR);
        $stmt->execute();
        $i = 0;
        while ($results = $stmt->fetch()) {
            $array[$i] = $results['Filenaam'];
            $i++;
        }
        return $array;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');

    }
}

function getHomepageCards($dbh, $query)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {

            $price = $results['hoogsteBod'];
            if(is_null($price)){
                $price = getStartPrice($dbh, $results['voorwerpnummer']);
            }
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        die();
        header('Location: errorpage.php?err=500');
    }
    return $itemCards;
}