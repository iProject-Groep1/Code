<?php
include('database-connect.php');
include('homepage-functions.php');
include('auction-item.php');


function searchItems($dbh)
{
    if (isset($_POST['Searching']) && !empty($_POST['Searching'])) {
        $search = htmlentities($_POST['Searching'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    }
    $searchItems = "";

    $queries['search'] = 'SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
FROM Voorwerp v left join Bod b ON v.voorwerpnummer = b.voorwerp join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
 WHERE titel like :bindValue and veilinggesloten = 0  GROUP BY Voorwerpnummer, titel, looptijdEindmoment,startprijs'; /* prepared statement */
    $bindValue = '%' . $search . '%';

    $searchItems .= getSearchItems($dbh, $queries['search'], $bindValue);


    echo $searchItems;
}

function getSearchItems($dbh, $query, $bindValue)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(":bindValue", $bindValue, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */

        $count = $stmt->rowCount();

        if ($count == 0) {
            return '.                     .                  Er zijn geen Items gevonden. ';
        }

        while ($results = $stmt->fetch()) {
            echo($results);
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

function getRubrieken($dbh, $searchTerm)
{
    $search = $searchTerm;
    $bindValue = '%' . $search . '%';


    $queries = ' select COUNT (vr.voorwerp) as aantal, rubrieknaam
              from Rubriek r join VoorwerpInRubriek vr on r.rubrieknummer = vr.rubriek_op_laagste_Niveau
  				                   join Voorwerp v on vr.voorwerp = v.voorwerpnummer
    	        where  titel like :bindValue and veilinggesloten = 0 group by  rubrieknaam ';
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
            /* <input type="checkbox" name="vehicle1" value="Bike"> I have a bike<br>*/

            $return .= '<input type="radio" name="rubriek" value="' . $row['rubrieknaam'] . '"> ' . $row['rubrieknaam'] . ' (' . $row['aantal'] . ')<br>';

        }
        echo $return;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        //  header('Location: ../errorpage.php?err=500');
    }

}

function getVerfijn($dbh)
{
    if (isset($_POST['rubriek'])) {
        $bindValue2 = $_POST['rubriek'];
    } else return '.   .         Geen rubriek geslecteerd.';
    if (isset($_POST['searchterm'])) {
        $bindValue = '%' . $_POST['searchterm'] . '%';
        $rubrieken = array();
        $rubrieken = htmlentities($_POST['rubriek'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
sort($rubrieken);
$bindValue = '%boot%';

$or = '';
 foreach ($rubrieken as $key) {
     $or .= " rubrieknaam =  $key  or ";
 }
 $or = substr($or, 0, -3);

$query = "SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp)
          AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
         FROM Voorwerp v left join Bod b ON v.voorwerpnummer = b.voorwerp
                         join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
         WHERE titel like :bindValue and veilinggesloten = 0 and voorwerpnummer in
          (select voorwerp from VoorwerpInRubriek vr join Rubriek r on r.rubrieknummer = vr.rubriek_op_laagste_Niveau where
               $or) GROUP BY Voorwerpnummer, titel, looptijdEindmoment,startprijs"; /* prepared statement */

echo getSearchItems($dbh, $query, $bindValue);
} else {
        return '.    .         Geen zoekterm opgegeven.';
    }

    $query = "SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp)
          AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
         FROM Voorwerp v left join Bod b ON v.voorwerpnummer = b.voorwerp
                         join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
         WHERE titel like ? and veilinggesloten = 0 and voorwerpnummer in
         (select voorwerp from VoorwerpInRubriek vr join Rubriek r on r.rubrieknummer = vr.rubriek_op_laagste_Niveau where rubrieknaam = ? )
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
