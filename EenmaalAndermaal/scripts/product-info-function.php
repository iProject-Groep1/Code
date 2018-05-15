

<?php

/*in detailpage:
require_once('scripts/product-info-function.php');

';
echo getProductInfo($dbh);
echo '*/

function getProductInfo($databasehandler){
    $voorwerpnummer = 1; //hier moet iets staan als $_GET['voorwerpnummer']; de 1 is een tijdelijke harde variabele.

    $query = "SELECT titel, beschrijving, betalingswijze, betalingsinstructie, plaatsnaam, land, verzendkosten, verzendinstructies, verkoper
              FROM dbo.Voorwerp
              WHERE voorwerpnummer = $voorwerpnummer";
    $data = $databasehandler->query($query);
    while ($row = $data->fetch()) { //loopt elke row van de resultaten door
        $productInformatie = '<div class="uk-grid uk-grid-large"><div class="uk-width-2-3"><h4>Productbeschrijving </h4><p>'. $row['beschrijving'] .'</p></div>';
        $productInformatie .= '<div class="uk-width-1-3"><h4>Betalingswijze</h4><p>'. $row['betalingswijze'] .'</p>';
        $productInformatie .= '<h4>Betalingsinstructie</h4><p>'. $row['betalingsinstructie'] .'</p>';
        $productInformatie .= '<h4>Plaatsnaam & land</h4><p>'. $row['plaatsnaam'] .', '. $row['land'] .'</p>';
        $productInformatie .= '<h4>Verzendkosten</h4><p>'. $row['verzendkosten'] .'</p>';
        $productInformatie .= '<h4>Verzendingstructies</h4><p>'. $row['verzendinstructies'] .'</p>';
        $productInformatie .= '<h4>Verkoper</h4><p>'. $row['verkoper'] .'</p></div></div>';

        return $productInformatie;
    }
}
 
