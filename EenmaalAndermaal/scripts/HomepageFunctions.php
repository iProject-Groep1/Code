<?php


function getTimeToEnd {
    try {
        $stmt = dbConnect()->prepare("
 	 select v.looptijdeindeDag, v.looptijdeindeTijdstip, v.veilinggesloten 
 	 from Voorwerp v ");

	/*  TODO: het stmt is nog niet compleet qua tijden */

    $stmt->execute();
    $filmData = $stmt->fetch(PDO::FETCH_ASSOC);

    return $filmData;

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}





