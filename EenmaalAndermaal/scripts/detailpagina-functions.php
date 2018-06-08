<?php


function setRelevantItems($dbh, $rubriek_op_laagste_Niveau, $voorwerp)
{
    $relevantItems = '';
    try {
        $stmt = $dbh->prepare("SELECT top 4 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd FROM Voorwerp v left join Bod b ON v.voorwerpnummer = b.voorwerp join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp  WHERE r.rubriek_op_laagste_Niveau = :rubriek_op_laagste_Niveau AND voorwerpnummer != :voorwerpnummer and veilinggesloten = 0 GROUP BY Voorwerpnummer, titel, looptijdEindmoment"); /* prepared statement */
        $stmt->bindValue(":voorwerpnummer", $voorwerp, PDO::PARAM_STR);
        $stmt->bindValue(":rubriek_op_laagste_Niveau", $rubriek_op_laagste_Niveau, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $relevantItems .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $results['hoogsteBod'], $results['voorwerpnummer'], $dbh);
        }
        echo $relevantItems;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
}


function getRelevantItems($dbh, $voorwerp)
{
    try {
        $stmt = $dbh->prepare("SELECT rubriek_op_laagste_Niveau FROM VoorwerpInRubriek V WHERE V.voorwerp = :voorwerp"); /* prepared statement */
        $stmt->bindValue(":voorwerp", $voorwerp, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            setRelevantItems($dbh, $results['rubriek_op_laagste_Niveau'], $voorwerp);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
}


function getProductInfo($dbh)
{
    $objectNumber = $_GET['id'];
    $productInformation = '';
    $sellerRating = "";
    try {
        $stmt = $dbh->prepare("SELECT beschrijving, betalingswijze, betalingsinstructie, plaatsnaam, land, verzendkosten, verzendinstructies, verkoper, rating FROM dbo.Voorwerp LEFT JOIN Verkoper ON verkoper = gebruikersnaam WHERE voorwerpnummer = :voorwerp");
        $stmt->bindValue(":voorwerp", $objectNumber, PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch()) { //loopt elke row van de resultaten door
            $productInformation .= '<div class="uk-child-width-1-2@l uk-width-1-1" uk-grid><div><h4 class="uk-text-center uk-height-">Productbeschrijving</h4><p>' . $row['beschrijving'] . '</p></div>';
            $productInformation .= '<div><h4 class="h4-no-bottom">Betalingswijze</h4><p>' . $row['betalingswijze'] . '</p>';
            $productInformation .= '<h4 class="h4-no-bottom">Betalingsinstructie</h4><p>' . $row['betalingsinstructie'] . '</p>';
            $productInformation .= '<h4 class="h4-no-bottom">Plaatsnaam & land</h4><p>' . $row['plaatsnaam'] . ', ' . $row['land'] . '</p>';
            $productInformation .= '<h4 class="h4-no-bottom">Verzendkosten</h4><p>' . $row['verzendkosten'] . '</p>';
            $productInformation .= '<h4 class="h4-no-bottom">Verzendingstructies</h4><p>' . $row['verzendinstructies'] . '</p>';
            $productInformation .= '<h4 class="h4-no-bottom">Verkoper</h4><p>' . $row['verkoper'] . ' ';
            if ($row['rating'] != NULL) {
                $numberOfStars = (int)$row['rating'] /= 20;
                for ($i = 0; $i < $numberOfStars; $i++) {
                    $productInformation .= '<span uk-icon="star" class="rating-star"></span>';
                }
                for ($i = 0; $i < 5 - $numberOfStars; $i++) {

                    $productInformation .= '<span uk-icon="star"></span>';

                }
            }
            $productInformation .= '</p></div></div>';
        }
        return $productInformation;
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
}

function getAuctionStatus($dbh)
{
    $objectNumber = $_GET['id'];
    try {
        $stmt = $dbh->prepare("SELECT veilinggesloten FROM dbo.Voorwerp WHERE voorwerpnummer = :voorwerp");
        $stmt->bindValue(":voorwerp", $objectNumber, PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch()) { //loopt elke row van de resultaten door
            $auctionStatus = $row['veilinggesloten'];

        }
        return $auctionStatus;
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
}


?>
