<?php
include('database-connect.php');
include('homepage-functions.php');
include('auction-item.php');


 function searchItems($dbh)
{
  if (isset($_POST['Searching']) && !empty($_POST['Searching'])) {
    $search =  $_POST['Searching'] ;
  }
  $searchItems = '';

      $queries['search'] = 'SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
FROM Voorwerp v left join Bod b ON v.voorwerpnummer = b.voorwerp join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
 WHERE titel like :bindValue and veilinggesloten = 0  GROUP BY Voorwerpnummer, titel, looptijdEindmoment,startprijs' ; /* prepared statement */
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
                $price =$results['startprijs']  ;
            }
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        die();
        header('Location: ../errorpage.php?err=500');
    }
    return $itemCards;
}

function getRubrieken($dbh,$searchTerm ){
  $search =  $searchTerm;
  $bindValue = '%' . $search .'%' ;


$queries = ' select COUNT (vr.voorwerp) as aantal, rubrieknaam
              from Rubriek r join VoorwerpInRubriek vr on r.rubrieknummer = vr.rubriek_op_laagste_Niveau
  				                   join Voorwerp v on vr.voorwerp = v.voorwerpnummer
    	        where  titel like :bindValue and veilinggesloten = 0 group by  rubrieknaam ';
$return = '';
try {
  $stmt = $dbh->prepare($queries); /* prepared statement */
  $stmt->bindValue(":bindValue", $bindValue , PDO::PARAM_STR); /* helpt tegen SQL injection */
  $stmt->execute(); /* stuurt alles naar de server */

$X=0;
  while ($row = $stmt->fetch()) {
/* <input type="checkbox" name="vehicle1" value="Bike"> I have a bike<br>*/

        $return .= '<input type="checkbox" name="rubriek['.$X.']" value="'. $row['rubrieknaam'] . '"> '. $row['rubrieknaam'] . ' (' . $row['aantal'] .')<br>';
          $X=$X+1;
            }
      echo $return;
  }
 catch (PDOException $e) {
    echo "Fout" . $e->getMessage();
  //  header('Location: ../errorpage.php?err=500');
}

}

function getVerfijn($dbh){
$rubrieken = array();
$rubrieken =  $_POST['rubriek'];
sort($rubrieken);
$bindValue = '%boot%';

$or = '';
 foreach ($rubrieken as $key ) {
   $or .= " rubrieknaam =  $key  or ";
 }
 $or = substr($or, 0 , -3);

$query=  'SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp)
          AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd,startprijs
         FROM Voorwerp v left join Bod b ON v.voorwerpnummer = b.voorwerp
                         join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp
         WHERE titel like :bindValue and veilinggesloten = 0 and voorwerpnummer in
          (select voorwerp from VoorwerpInRubriek vr join Rubriek r on r.rubrieknummer = vr.rubriek_op_laagste_Niveau where
               '.$or.') GROUP BY Voorwerpnummer, titel, looptijdEindmoment,startprijs' ; /* prepared statement */

die();
echo getSearchItems($dbh, $query,$bindValue);
}



 ?>
