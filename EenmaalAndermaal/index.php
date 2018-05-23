<?php
$pageTitle = 'EenmaalAndermaal';
require_once('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');
?>


<body>

<?php
//haalt de top 4 populaire items uit de database. Deze top 4 is gebaseerd op de veilingen met de meeste boden (aflopend)
$queries['Populairste veilingen'] = "select top 4 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod , CURRENT_TIMESTAMP AS serverTijd, count(b.voorwerp) as aantal from Voorwerp v join bod b on v.voorwerpnummer = b.voorwerp where datediff(minute, CURRENT_TIMESTAMP, LooptijdEindmoment) > 10   group by voorwerpnummer, titel, looptijdEindmoment  order by aantal desc";
//haalt de top 8 duurste veilingen uit de database. Deze 8 worden vervolgens d.m.v. de createItem(); functie.
$queries['Duurste veilingen'] = "SELECT TOP 8 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd FROM Voorwerp v join Bod b ON v.voorwerpnummer = b.voorwerp WHERE datediff(minute, CURRENT_TIMESTAMP, LooptijdEindmoment) > 10 GROUP BY Voorwerpnummer, titel, looptijdEindmoment ORDER BY hoogsteBod desc";
//haalt de  top 5 koopjes uit de database. TODO: bodbedrag < 30 veranderen zodra er meer items in staan.
$queries['Koopjes'] = "select top 5 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod , CURRENT_TIMESTAMP AS serverTijd from Voorwerp v join bod b on v.voorwerpnummer = b.voorwerp where datediff(minute, CURRENT_TIMESTAMP, LooptijdEindmoment) > 10 AND v.veilinggesloten = 0 group by voorwerpnummer, titel, looptijdEindmoment HAVING MAX(bodBedrag) < 30";
//haalt de top 5 laatste kans items uit de database
$queries['Laatste kans'] = "select top 5 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod , CURRENT_TIMESTAMP AS serverTijd from Voorwerp v join bod b on v.voorwerpnummer = b.voorwerp where datediff(minute, CURRENT_TIMESTAMP, LooptijdEindmoment) < 10 AND v.veilinggesloten = 0 group by voorwerpnummer, titel, looptijdEindmoment";
$attentionSeekers = "";
foreach($queries as $soort => $query){
    $attentionSeekers .=  '<div class="uk-card auctions-reset-margin uk-card-default uk-card-body">
    <h3 class="uk-display-block uk-align-center uk-text-center">'.$soort.'</h3>
    <p>
    <div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">'.getHomepageCards($dbh, $query).'</div>
    </p>
    </div>
    <hr>';
}

echo $attentionSeekers;

require_once('scripts/footer.php');
?>

</body>

