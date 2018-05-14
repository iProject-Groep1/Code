<<?php
include('scripts/database-connect.php')

function Get_country($dbh){

  try {
      $stmt = $dbh->query(""); /* prepared statement */

      while ($row = $stmt->fetch_assoc()){
      echo "<option value=\" . $row['land'] . </option>";
       }

      }



   catch (PDOException $e) {
      echo "Fout" . $e->getMessage();
  }
}



 ?>
