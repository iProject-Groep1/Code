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

// Deze functie haalt alle voorwerpID's uit de database. Deze id's worden vervolgens in de functie gestopt waardoor alle foutieve id's geskipt worden.
//function checkNumbers($dbh)
//{
//    $results = "";
//    echo '
//                <div class="uk-child-width-1-4@m uk-grid" uk-grid>';
//    try {
//        $stmt = $dbh->query("SELECT Voorwerpnummer FROM Voorwerp v WHERE v.Voorwerpnummer IS NOT NULL"); /* prepared statement */
//
//        while ($row = $stmt->fetch()) {
//            createItem($dbh, $row['Voorwerpnummer']);
//            echo "<br>";
//
//        }
//        echo '</div>';
//        return $results;
//
//    } catch (PDOException $e) {
//        echo "Fout" . $e->getMessage();
//    }
//}


//Deze functie vraagt de tijd van de database op. Deze tijd modified hij met +10 minuten.
// Deze functie is echter nu nog niet nodig, maar voor latere doeleinde is dit handig.
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


//Deze functie pakt de Titel van de veiling (gekoppeld aan het ID dat meegegeven wordt).
//function getAuctionTitel($dbh, $id)
//{
//    try {
//        $stmt = $dbh->prepare("SELECT Titel FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
//        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
//        $stmt->execute(); /* stuurt alles naar de server */
//        while ($results = $stmt->fetch()) {
//            $row = $results['Titel'];
//        }
//        return $row;
//    } catch (PDOException $e) {
//        echo "Fout" . $e->getMessage();
//    }
//}


// Deze functie vraagt de filename van het plaatje van de auction op. Deze wordt opgehaald uit de database.
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
        header('Location: errorpage.php?err=500');
    }
    return $itemCards;
}





