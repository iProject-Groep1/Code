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
    $categoryArray;
        try {
        $stmt = $dbh->prepare("SELECT	P4.rubrieknaam AS Parent4Rubrieknaam,
		P4.rubrieknummer AS Parent4Rubrieknummer,
		P3.rubrieknaam AS Parent3Rubrieknaam,
		P3.rubrieknummer AS Parent3Rubrieknummer,
		P2.rubrieknaam AS Parent2Rubrieknaam,
		P2.rubrieknummer AS Parent2Rubrieknummer,
		P1.rubrieknaam AS Parent1Rubrieknaam,
		P1.rubrieknummer AS Parent1Rubrieknummer,
		S.rubrieknaam AS HuidigRubrieknaam, 
		S.rubrieknummer AS HuidigRubrieknummer		
FROM	rubriek S
		LEFT JOIN rubriek P1 ON P1.rubrieknummer = S.parent
		LEFT JOIN rubriek P2 ON P2.rubrieknummer = P1.parent
		LEFT JOIN rubriek P3 ON P3.rubrieknummer = P2.parent
		LEFT JOIN rubriek P4 ON P4.rubrieknummer = P3.parent
WHERE	S.rubrieknummer = :categoryID");
        $stmt->bindValue(":categoryID", $_GET['categoryID'], PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch()) { //loopt elke row van de resultaten door
            $categoryArray[$row['Parent4Rubrieknaam']] = $row['Parent4Rubrieknummer'];
            $categoryArray[$row['Parent3Rubrieknaam']] = $row['Parent3Rubrieknummer'];
            $categoryArray[$row['Parent2Rubrieknaam']] = $row['Parent2Rubrieknummer'];
            $categoryArray[$row['Parent1Rubrieknaam']] = $row['Parent1Rubrieknummer'];
            $categoryArray[$row['HuidigRubrieknaam']] = $row['HuidigRubrieknummer'];
        }
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }


    //breadcrumb
    echo '
<div class="uk-margin-detail">
<ul class="uk-breadcrumb uk-width-1-1" >
    <li><a href="index.php">Home</a></li>';
    //loopt door de bovenstaande rubrieken en vult de breadcrumb
    foreach ($categoryArray as $categoryName => $categoryID) {
        if (!empty($categoryID && $categoryID != -1)) {
            echo '<li><a href="category.php?categoryID=' . $categoryID . '">' . $categoryName . '</a></li>';
        }
    }
    echo '</ul>
</div>
';
    echo '<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
    <h3 class="uk-display-block uk-align-center uk-text-center">'.array_search($_GET['categoryID'], $categoryArray).'</h3>
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
