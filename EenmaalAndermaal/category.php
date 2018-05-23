<?php
$pageTitle = 'Rubriekpagina';
require_once('scripts/header.php');
include('scripts/homepage-functions.php');

$idCorrect = false;
if (isset($_GET['categoryID']) && !empty($_GET['categoryID'])) {
    try {
        $stmt = $dbh->prepare("SELECT COUNT(rubrieknummer) AS aantal FROM rubriek WHERE rubrieknummer = :rubrieknummer");
        $stmt->bindValue(":rubrieknummer", $_GET['categoryID'], PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            if ($row['aantal'] == 0) {
                $idCorrect = false;
            } else {
                $idCorrect = true;
            }
        }
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
    }
} else {
    header('Location: errorpage.php?err=404');
}

if ($idCorrect) {
    echo getHomepageCards($dbh);
} else {
    header('Location: errorpage.php?err=404');
}


function getAuctionCards($dbh)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare("v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod , CURRENT_TIMESTAMP AS serverTijd, count(b.voorwerp) as aantal from Voorwerp v join bod b on v.voorwerpnummer = b.voorwerp where veilinggesloten = 0 AND group by voorwerpnummer, titel, looptijdEindmoment  order by aantal desc"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $results['hoogsteBod'], $results['voorwerpnummer']);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    return $itemCards;
}
