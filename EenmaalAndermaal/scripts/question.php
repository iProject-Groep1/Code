<?php
include('database-connect.php');


function Get_question($dbh){
$return = '';
  try {
      $stmt = $dbh->prepare("select [vraagnummer], [vraagtekst] from Vraag"); /* prepared statement */
      $stmt->execute(); /* stuurt alles naar de server */

      while ($row = $stmt->fetch()){

        $return .= '<option value="'. $row ['vraagnummer'] .'"> '.$row['vraagtekst'].'</option>';
        
       }

      }
   catch (PDOException $e) {
      echo "Fout" . $e->getMessage();
       header('Location: errorpage.php?err=500');
  }
  return $return;
};

 ?>
