<?php
include('database-connect.php');
include('homepage-functions.php');
include('scripts/auction-item.php');


 function searchItems($dbh)
{
  if (isset($_POST['Searching']) && !empty($_POST['Searching'])) {
    $search =  $_POST['Searching'] ;
  }
  $searchItems = '';

      $queries['search'] = 'SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd
FROM Voorwerp v join Bod b ON v.voorwerpnummer = b.voorwerp join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
 WHERE titel like :bindValue and veilinggesloten = 0  GROUP BY Voorwerpnummer, titel, looptijdEindmoment' ; /* prepared statement */
      $bindValue = '%' . $search .'%' ;

  $searchItems .=   getSearchItems($dbh, $queries['search'],$bindValue);


echo $searchItems;
}

function getSearchItems($dbh, $query,$bindValue)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(":bindValue", $bindValue , PDO::PARAM_STR); /* helpt tegen SQL injection */
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


 ?>
