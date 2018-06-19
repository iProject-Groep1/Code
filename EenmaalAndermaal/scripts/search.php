<?php
include('database-connect.php');
include('homepage-functions.php');
include('auction-item.php');

//bepaal zoekquery en maak itemCards van de resultaten.
function searchItems($dbh)
{
    $search = "";
    if (isset($_POST['Searching']) && !empty($_POST['Searching'])) {
        $search = htmlentities($_POST['Searching'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    }
    $searchItems = "";
    $queries['search'] = 'SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
                          FROM Voorwerp v 
                          LEFT JOIN Bod b ON v.voorwerpnummer = b.voorwerp 
                          JOIN VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
                          WHERE titel LIKE :bindValue AND veilinggesloten = 0  
                          GROUP BY Voorwerpnummer, titel, looptijdEindmoment,startprijs'; /* prepared statement */
    $bindValue = '%' . $search . '%';
    $searchItems .= getSearchItems($dbh, $queries['search'], $bindValue);
    echo $searchItems;
}

//creeër itemcards
function getSearchItems($dbh, $query, $bindValue)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(":bindValue", $bindValue, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        $count = $stmt->rowCount();
        if ($count == 0) {
            return 'Er zijn geen Items gevonden. ';
        }
        while ($results = $stmt->fetch()) {
            $price = $results['hoogsteBod'];
            if (is_null($price)) {
                $price = $results['startprijs'];
            }
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
    return $itemCards;
}

//haal een lijst op met rubrieken waar de voorwerpen van de zoekopdracht zich in bevinden.
function getRubrieken($dbh, $searchTerm)
{
    $search = $searchTerm;
    $bindValue = '%' . $search . '%';
    $queries = '  SELECT COUNT (vr.voorwerp) AS aantal, rubrieknaam
                  FROM Rubriek r 
                  JOIN VoorwerpInRubriek vr ON r.rubrieknummer = vr.rubriek_op_laagste_Niveau
  				  JOIN Voorwerp v ON vr.voorwerp = v.voorwerpnummer
    	          WHERE  titel LIKE :bindValue AND veilinggesloten = 0 
    	          GROUP BY rubrieknaam ';
    $return = '';
    try {
        $stmt = $dbh->prepare($queries); /* prepared statement */
        $stmt->bindValue(":bindValue", $bindValue, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */

        $count = $stmt->rowCount();

        if ($count == 0) {
            return 'Er zijn geen Items gevonden. ';
        }

        while ($row = $stmt->fetch()) {
            $return .= '<input type="radio" name="rubriek" value="' . $row['rubrieknaam'] . '"> ' . $row['rubrieknaam'] . ' (' . $row['aantal'] . ')<br>';
        }
        echo $return;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
}

//haal verfijnde zoekresultaten op (rubriek is geselecteerd.
function getVerfijn($dbh)
{
    if (isset($_POST['rubriek'])) {
        $bindValue2 = $_POST['rubriek'];
    } else return '.   .         Geen rubriek geslecteerd.';
    if (isset($_POST['searchterm'])) {
        $_POST['searchterm'] = htmlentities($_POST['searchterm'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
        $bindValue = '%' . $_POST['searchterm'] . '%';
    } else {
        return ' Geen zoekterm opgegeven ';
    }
    $query = "SELECT v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
              FROM Voorwerp v 
              LEFT JOIN Bod b ON v.voorwerpnummer = b.voorwerp
              JOIN VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
              WHERE titel LIKE ? AND veilinggesloten = 0 AND voorwerpnummer IN (SELECT voorwerp 
                                                                                FROM VoorwerpInRubriek vr 
                                                                                JOIN Rubriek r ON r.rubrieknummer = vr.rubriek_op_laagste_Niveau 
                                                                                WHERE rubrieknaam = ? )
              GROUP BY Voorwerpnummer, titel, looptijdEindmoment,startprijs"; /* prepared statement */

    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(1, $bindValue, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->bindValue(2, $bindValue2, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */

        $count = $stmt->rowCount();
        if ($count = 0) {
            return 'Er zijn geen Items gevonden. ';
        }
        while ($results = $stmt->fetch()) {
            $price = $results['hoogsteBod'];
            if (is_null($price)) {
                $price = $results['startprijs'];
            }
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
    return $itemCards;
}
?>
