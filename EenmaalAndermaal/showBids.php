<?php
$pageTitle = "Mijn Biedingen";
include('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');

if (isset($_SESSION['noChance']) && !empty($_SESSION['noChance'])) {
    echo $_SESSION['noChance'];
    $_SESSION['noChance'] = "";
}
if (isset($_SESSION['chance']) && !empty($_SESSION['chance'])) {
    echo $_SESSION['chance'];
    $_SESSION['chance'] = "";
}

if (isset($_SESSION['profileNotification']) && !empty($_SESSION['profileNotification'])) {
    echo $_SESSION['profileNotification'];
    $_SESSION['profileNotification'] = "";
}

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    //haal bijna alle informatie van een gebruiker op
//TODO query aanpassen zodat gemiddelde feedback en telefoonnummers mee wordt genomen.
    $data = "";
    try {
        $stmt = $dbh->prepare("SELECT  g.gebruikersnaam, telefoon, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mail_adres, verkoper, rating FROM gebruiker g LEFT JOIN gebruikerstelefoon on gebruikersnaam = gebruiker LEFT JOIN verkoper v on g.gebruikersnaam = v.gebruikersnaam WHERE g.gebruikersnaam like :gebruikersnaam  ORDER BY volgnr");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    ?>
    <h2 class="uk-text-center">Mijn Biedingen</h2>
    <div class="uk-margin-left@l uk-margin-left@m">

        <div class="profile-sidebar uk-align-center@m">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
                <li class="uk-parent uk-open">
                    <a href="#">EenmaalAndermaal</a>
                    <ul class="uk-nav-sub" aria-hidden="false">
                        <li><a href="profile.php">Mijn Profiel</a></li>
                        <li><a href="changeProfile.php">Gegevens wijzigen</a></li>
                        <li><a href="myAuctions.php">Mijn Veilingen</a></li>
                        <li><a href="showBids.php">Mijn Biedingen</a></li>
                        <li><a class="uk-button uk-button-primary" href="search-Rubriek.php">Plaats Advertentie</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
                <!-- gebruikersinformatie -->


                <?php

                searchMyAuctions($dbh);

                ?>


            <div class="uk-overflow-auto">
                <!-- contactinformatie -->

            </div>

        </div>
    </div>
    </div>

    <?php

} else {
    header('Location: login.php?');
}


include('scripts/footer.php');

function searchMyBids($dbh)
{

    $searchItems = '';

    $queries['search'] = 'SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd
FROM Voorwerp v full outer join Bod b ON v.voorwerpnummer = b.voorwerp join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp join Gebruiker g on g.gebruikersnaam = v.verkoper
 WHERE g.gebruikersnaam like :bindvalue and veilinggesloten = 0  GROUP BY Voorwerpnummer, titel, looptijdEindmoment order by titel ' ; /* prepared statement */
    $bindValue = $_SESSION['username'];
    $searchItems .=   getMyBids($dbh, $queries['search'],$bindValue);
    echo $searchItems;
}

function getMyBids($dbh, $query, $bindvalue)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(":bindvalue", $bindvalue , PDO::PARAM_STR); /* helpt tegen SQL injection */
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
    }
    return $itemCards;
}