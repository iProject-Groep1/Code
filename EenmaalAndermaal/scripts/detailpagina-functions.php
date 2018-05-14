<?php


function setRelevantItems($dbh, $rubriek_op_laagste_Niveau)
{
    try {

        $stmt = $dbh->prepare("SELECT top 4 voorwerp as voorwerpen FROM VoorwerpInRubriek V WHERE V.rubriek_op_laagste_Niveau = :rubriek_op_laagste_Niveau"); /* prepared statement */
        $stmt->bindValue(":rubriek_op_laagste_Niveau", $rubriek_op_laagste_Niveau, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            createItem($dbh, $results['voorwerpen']);
        }

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
}


function getRelevantItems($dbh, $voorwerp) {
    $stmt = $dbh->prepare("SELECT rubriek_op_laagste_Niveau FROM VoorwerpInRubriek V WHERE V.voorwerp = :voorwerp"); /* prepared statement */
    $stmt->bindValue(":voorwerp", $voorwerp, PDO::PARAM_STR); /* helpt tegen SQL injection */
    $stmt->execute(); /* stuurt alles naar de server */
    while ($results = $stmt->fetch()) {
        setRelevantItems($dbh, $results['rubriek_op_laagste_Niveau']);
    }
}