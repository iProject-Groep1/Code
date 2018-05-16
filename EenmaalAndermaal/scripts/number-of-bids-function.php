<?php
function getBids($databasehandler)
{
    $bid = "";
    $objectNumber = $_GET['id'];
    $query = "SELECT bodbedrag, gebruiker
              FROM dbo.Bod
              WHERE voorwerp = $objectNumber
              ORDER BY bodbedrag DESC";
    $data = $databasehandler->query($query);
    while ($row = $data->fetch()) {
        $bid .= '<div class="uk-grid"><div class="uk-width-1-2">'. $row['bodbedrag'] .'</div><div class="uk-width-1-2">'. $row['gebruiker'] . '</div></div>';
    }
    return $bid;
}





























//while($row = $data->fetchAll(PDO::FETCH_ASSOC)){
//foreach($row as $field) {
// $bid = '<p>' . $field['bodbedrag'] + $field['gebruiker'] . '</p>';
//}