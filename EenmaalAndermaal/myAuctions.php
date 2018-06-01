<?php
$pageTitle = 'Mijn Veilingen';
include('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');
include('scripts/notify-bid.php');
?>

<h2 class="uk-text-center">Mijn Veilingen</h2>

<?php
try {
    $veilingen = "";
    $query = "SELECT TOP 8 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd FROM Voorwerp v inner join Gebruiker g ON v.verkoper = g.gebruikersnaam left join bod b on v.voorwerpnummer = b.voorwerp WHERE g.gebruikersnaam = 'mediazone-de' AND veilinggesloten = 0 GROUP BY Voorwerpnummer, titel, looptijdEindmoment ORDER BY hoogsteBod desc";

    $stmt = $dbh->prepare("SELECT TOP 8 v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd FROM Voorwerp v inner join Gebruiker g ON v.verkoper = g.gebruikersnaam left join bod b on v.voorwerpnummer = b.voorwerp WHERE g.gebruikersnaam = 'mediazone-de' AND veilinggesloten = 0 GROUP BY Voorwerpnummer, titel, looptijdEindmoment ORDER BY hoogsteBod desc");
    //$stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    $mijnVeilingen = $stmt->fetch();
} catch (PDOException $e) {
    echo "Fout" . $e->getMessage();
    header('Location: errorpage.php?err=500');
}
foreach($mijnVeilingen as $item){
$veilingen .=  '<div class="uk-card auctions-reset-margin uk-card-default no-shadow uk-card-body">
    <a href="relevantpage.php?Titel='. $query .'">
    <h3 class="uk-display-block uk-align-center uk-text-center">'.$query.'</h3>
    </a>
    <p>
    <div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">'.getHomepageCards($dbh, $query).'</div>
    </p>
    </div>
    <hr>';
}
echo $veilingen;
