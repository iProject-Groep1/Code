

<?php

/*in detailpage:
require_once('scripts/product-info-function.php');

';
echo getProductInfo($dbh);
echo '*/

function getProductInfo($databasehandler){
    $voorwerpnummer = $_GET['id'];

    $query = "SELECT titel, beschrijving, betalingswijze, betalingsinstructie, plaatsnaam, land, verzendkosten, verzendinstructies, verkoper
              FROM dbo.Voorwerp
              WHERE voorwerpnummer = $voorwerpnummer";
    $data = $databasehandler->query($query);
    while ($row = $data->fetch()) { //loopt elke row van de resultaten door
        $productInformatie = '<div class="uk-grid uk-grid-large"><div class="uk-width-2-3"><h4 class="h4-no-bottom">Productbeschrijving </h4><p>'. $row['beschrijving'] .'</p></div>';
        $productInformatie .= '<div class="uk-width-1-3"><h4 class="h4-no-bottom">Betalingswijze</h4><p>'. $row['betalingswijze'] .'</p>';
        $productInformatie .= '<h4 class="h4-no-bottom">Betalingsinstructie</h4><p>'. $row['betalingsinstructie'] .'</p>';
        $productInformatie .= '<h4 class="h4-no-bottom">Plaatsnaam & land</h4><p>'. $row['plaatsnaam'] .', '. $row['land'] .'</p>';
        $productInformatie .= '<h4 class="h4-no-bottom">Verzendkosten</h4><p>'. $row['verzendkosten'] .'</p>';
        $productInformatie .= '<h4 class="h4-no-bottom">Verzendingstructies</h4><p>'. $row['verzendinstructies'] .'</p>';
        $productInformatie .= '<h4 class="h4-no-bottom">Verkoper</h4><p>'. $row['verkoper'] .'</p></div></div>';

        return $productInformatie;
    }
}

