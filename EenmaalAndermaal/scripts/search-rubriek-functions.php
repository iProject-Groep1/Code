<?php

function searchRubriek($dbh, $search)
{

    try {
        $SQL = "
SELECT COUNT(voorwerpnummer) AS aantal, r.rubrieknaam as naam, r.rubrieknummer as nummer
FROM Voorwerp v JOIN VoorwerpInRubriek vir ON v.voorwerpnummer = vir.voorwerp 
JOIN rubriek r ON  vir.rubriek_op_laagste_Niveau = r.rubrieknummer 
WHERE veilinggesloten = 0 
AND Rubrieknaam LIKE :search
GROUP BY r.rubrieknaam, r.rubrieknummer 
ORDER BY aantal desc";
        $bindSearch = '%' . $search . '%';

        $stmt = $dbh->prepare($SQL); /* prepared statement */
        $stmt->bindValue(":search", $bindSearch, PDO::PARAM_STR);
        $stmt->execute();
        $echo = '<div class="uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s uk-grid uk-margin-remove-left " uk-grid>';
        while ($results = $stmt->fetch()) {

            $echo .= '<a class="uk-padding-remove" href="upload.php?Rubriek=' . $results['naam'] . '&Rubrieknr=' . $results['nummer'] . '">' . $results['naam'] . '</a>';
        }
        $echo .= '</div>';
        echo $echo;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
}

