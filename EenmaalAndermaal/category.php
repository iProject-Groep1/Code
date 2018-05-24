<?php
$pageTitle = 'Rubriekpagina';
require_once('scripts/header.php');
include('scripts/homepage-functions.php');
include('scripts/auction-item.php');
include('scripts/bid-functions.php');
include('scripts/notify-bid.php');

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
    //TODO: Rubriektitel dynamisch maken
    echo '<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
    <h3 class="uk-display-block uk-align-center uk-text-center">Rubriektitel</h3>
    <p>
<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">'.getAuctionCards($dbh, $_GET['categoryID']).'</div>
</p></div>';
} else {
    header('Location: errorpage.php?err=404');
}


function getAuctionCards($dbh, $rubrieknummer)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare("SELECT v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod , CURRENT_TIMESTAMP AS serverTijd, count(b.voorwerp) as aantal from Voorwerp v join VoorwerpInRubriek vir ON v.voorwerpnummer = vir.voorwerp left join bod b on v.voorwerpnummer = b.voorwerp where veilinggesloten = 0 AND vir.rubriek_op_laagste_Niveau = :rubrieknummer group by voorwerpnummer, titel, looptijdEindmoment  order by aantal desc"); /* prepared statement */
        $stmt->bindValue(":rubrieknummer", $rubrieknummer, PDO::PARAM_STR);
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $price = $results['hoogsteBod'];
            if(is_null($price)){
                $price = getStartPrice($dbh, $results['voorwerpnummer']);
            }
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    return $itemCards;
}
