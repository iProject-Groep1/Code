<?php
include('database-connect.php');


function Get_country($dbh){
$return = '';
  try {
      $stmt = $dbh->prepare("select land from land"); /* prepared statement */
      $stmt->execute(); /* stuurt alles naar de server */

      while ($row = $stmt->fetch()){
      $return .= '<option value="'. $row['land'] .'"> '.$row['land'].'</option>';
       }

      }
   catch (PDOException $e) {
      echo "Fout" . $e->getMessage();
  }
  echo $return;
};

 ?>
