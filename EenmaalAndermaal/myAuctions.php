<?php
$pageTitle = "Mijn Veilingen";
include('scripts/header.php');
include('scripts/auction-item.php');
include('scripts/homepage-functions.php');
include('scripts/database-connect.php');
include('scripts/bid-functions.php');

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    //haal alle informatie van een gebruiker op
    $data = "";
    try {
        $stmt = $dbh->prepare("SELECT verkoper FROM gebruiker WHERE gebruikersnaam like :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    ?>
    <h2 class="uk-text-center">Mijn Veilingen</h2>
    <div class="uk-margin-left@l uk-margin-left@m minimal-height-itempage">

        <div class="profile-sidebar uk-align-center@m">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">
                <li class="uk-parent uk-open">
                    <a href="#">EenmaalAndermaal</a>
                    <ul class="uk-nav-sub" aria-hidden="false">
                        <li><a href="profile.php"><span uk-icon="user" class="uk-margin-small-right"></span>Mijn Profiel</a></li>
                        <li><a href="changeProfile.php"><span uk-icon="pencil" class="uk-margin-small-right"></span>Gegevens wijzigen</a></li>
                        <li><a href="showBids.php"><span uk-icon="cart" class="uk-margin-small-right"></span>Mijn Biedingen</a></li>
                        <?php
                        if ($data['verkoper'] == 0) {
                            ?>
                            <li><a href="become-seller.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Verkoper worden</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="myAuctions.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Mijn Veilingen</a></li>
                            <li><a class="uk-button uk-button-primary" href="search-Rubriek.php"><span uk-icon="plus" class="uk-margin-small-right"></span>Plaats Advertentie</a>
                            </li>
                            <?php
                        } ?>

                    </ul>
                </li>
            </ul>
        </div>


        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <h4>Hier worden producten getoond die nu actief zijn.</h4>
        </div>
        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <?php
            searchMyAuctions($dbh, 0);
            ?>
        </div>


        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <h4>Hier worden producten getoond die afgelopen zijn, neem zo snel mogelijk contact op met de winnaar!</h4>
        </div>
        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <?php
            searchMyAuctions($dbh, 1);
            ?>
        </div>


    </div>


    <?php

} else {
    header('Location: login.php?');
}


include('scripts/footer.php');

function searchMyAuctions($dbh, $status)
{
    $searchItems = "";

    $queries['search'] = "SELECT  v.voorwerpnummer, v.titel, v.looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam, MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd
FROM Voorwerp v full outer join Bod b ON v.voorwerpnummer = b.voorwerp join VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp join Gebruiker g on g.gebruikersnaam = v.verkoper
 WHERE g.gebruikersnaam like :bindvalue and veilinggesloten = $status  GROUP BY Voorwerpnummer, titel, looptijdEindmoment order by titel "; /* prepared statement */
    $bindValue = $_SESSION['username'];
    $searchItems .= getMyAuctions($dbh, $queries['search'], $bindValue, $status);
    echo $searchItems;
}

function getMyAuctions($dbh, $query, $bindvalue, $open)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(":bindvalue", $bindvalue, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        $count = $stmt->rowCount();
        if ($count == 0) {
            if (!$open) {
                echo '<div class="uk-alert-warning uk-margin-remove-left"><h2 class="uk-alert-warning">U heeft geen actieve veilingen.</h2><p>Ga naar <a href="search-Rubriek.php">deze</a> pagina om een veiling aan te maken.</p></div>';
            } else {
                echo '<div class="uk-alert-warning uk-margin-remove-left"><h2 class="uk-alert-warning">U heeft nog geen afgelopen veilingen.</h2><p>Kijk over een tijdje opnieuw.</p></div>';
            }
        }
        while ($results = $stmt->fetch()) {

            $price = $results['hoogsteBod'];
            if (is_null($price)) {
                $price = getStartPrice($dbh, $results['voorwerpnummer']);
            }
            $itemCards .= createItemScript($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    return $itemCards;
}