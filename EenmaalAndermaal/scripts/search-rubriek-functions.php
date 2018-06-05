<?php

function searchRubriek($dbh, $search)
{

    try {
        $SQL = "
SELECT TOP 5 COUNT(voorwerpnummer) AS aantal, r.rubrieknaam as naam, r.rubrieknummer as nummer
FROM Voorwerp v JOIN VoorwerpInRubriek vir ON v.voorwerpnummer = vir.voorwerp 
JOIN rubriek r ON  vir.rubriek_op_laagste_Niveau = r.rubrieknummer 
WHERE veilinggesloten = 0 
AND Rubrieknaam LIKE :search
GROUP BY r.rubrieknaam, r.rubrieknummer 
ORDER BY aantal desc";
        $bindSearch = '%' . $search .'%' ;

        $stmt = $dbh->prepare($SQL); /* prepared statement */
        $stmt->bindValue(":search", $bindSearch, PDO::PARAM_STR);
        $stmt->execute();
        $echo = "";
        while ($results = $stmt->fetch()) {

            $echo .='<a href="upload.php?Rubriek='. $results['naam'] .'&Rubrieknr='.$results['nummer'].'">'. $results['naam'] . '</a><br>';
        }
        echo $echo;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
}

?>
