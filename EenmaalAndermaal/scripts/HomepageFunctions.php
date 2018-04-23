function dbConnect {
  try {
    $hostname = "mssql.iproject.icasites.nl"; //Naam van de Server
    $dbname = "iproject1";    //Naam van de Database
    $username = "iproject1";      //Inlognaam
    $pw = "JaaK8kbQ8S";      //Password

    $pdo = new PDO ("sqlsrv:Server=$hostname;Database=$dbname;ConnectionPooling=0","$username","$pw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo; // "Connectie kunnen maken met de database!";
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}






function getTimeToEnd {
  try {
    $stmt = dbConnect()->prepare("
 	 select v.looptijdeindeDag, v.looptijdeindeTijdstip, v.veilinggesloten 
 	 from Voorwerp v 

	 TODO: het stmt is nog niet compleet qua tijden

    $stmt->execute(); 
    $filmData = $stmt->fetch(PDO::FETCH_ASSOC);

    return $filmData;

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}






/* In de parameter kan je nu opgeven tot hoeveel minuten deze filter ingesteld moet worden. */

function setEndingAuctions ($minutesToEnding){

  $itemTime = …  //TODO , een functie maken die de tijd van nu vergelijkt met de tijd van de veiling
  $EndingAuctionsList = {}; // TODO, Moet buiten de functie staan
  $numberOfAuctions = 20;


    if ($itemTime < $minutesToEnding) {
      if ($index < $numberOfAuctions ){
  	EndingAuctionsList[$index] = $itemTime // Dit moet een ID of titel etc zijn het voorwerp zijn.
    }
    $index ++;
  }

}
