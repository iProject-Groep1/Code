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
    }

}

//Deze functie pakt het hoogste bod van ieder product. Deze informatie haalt hij uit de database
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


//Deze functie pakt de Titel van de veiling (gekoppeld aan het ID dat meegegeven wordt).
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
    }
}

//Deze functie doet eigenlijk niks. Deze functie is in het leven geroepen om een rustigere/mooiere functie te hebben voor het bouwen van de veilingen.
function createItem($dbh, $id)
{
    createItemScript(getAuctionTitel($dbh, $id), getAuctionEnd($dbh, $id), getAuctionFilename($dbh, $id), getHighestBid($dbh, $id));
}


//Deze functie haalt de top 4 populaire items uit de database. Deze top 4 is gebasseerd op de veilingen met de meeste boden (aflopend)
function getPopularItems($dbh)
{
    try {
        $stmt = $dbh->prepare("select top 4 voorwerp, count(voorwerp) as aantal   from  BOD b join  voorwerp v on v.voorwerpnummer = b.voorwerp where datediff(minute, CURRENT_TIMESTAMP, LooptijdEindmoment) > 10   group by voorwerp order by aantal desc"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            createItem($dbh, $results['voorwerp']);
        }
        return;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


//Deze functie haalt de top 8 duurste veilingen uit de database. Deze 8 worden vervolgens d.m.v. de createItem(); functie.
function getHighItems($dbh)
{
    try {
        $stmt = $dbh->prepare("SELECT top 8 voorwerp , max(Bodbedrag) as prijs from  BOD b join  voorwerp v on v.voorwerpnummer = b.voorwerp  where datediff(minute, CURRENT_TIMESTAMP, LooptijdEindmoment) > 10 group by voorwerp order by prijs desc"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            createItem($dbh, $results['voorwerp']);
        }
        return;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}





