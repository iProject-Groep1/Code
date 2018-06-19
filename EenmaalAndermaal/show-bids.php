<?php
$pageTitle = "Mijn Biedingen";
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
    <h2 class="uk-text-center">Mijn Biedingen</h2>
    <div class="uk-margin-left@l uk-margin-left@m minimal-height-itempage">

        <div class="profile-sidebar uk-align-center@m">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav>
                <li class="uk-parent uk-open">
                    <a href="#">EenmaalAndermaal</a>
                    <ul class="uk-nav-sub" aria-hidden="false">
                        <li><a href="profile.php"><span uk-icon="user" class="uk-margin-small-right"></span>Mijn Profiel</a>
                        </li>
                        <li><a href="change-profile.php"><span uk-icon="pencil" class="uk-margin-small-right"></span>Gegevens
                                wijzigen</a></li>
                        <li><a href="show-bids.php"><span uk-icon="cart" class="uk-margin-small-right"></span>Mijn
                                Biedingen</a></li>
                        <?php
                        if ($data['verkoper'] == 0) {
                            ?>
                            <li><a href="become-seller.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Verkoper
                                    worden</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="my-auctions.php"><span uk-icon="tag" class="uk-margin-small-right"></span>Mijn
                                    Veilingen</a></li>
                            <li><a class="uk-button uk-button-primary" href="search-Rubriek.php"><span uk-icon="plus"
                                                                                                       class="uk-margin-small-right"></span>Plaats
                                    Advertentie</a>
                            </li>
                            <?php
                        } ?>

                    </ul>
                </li>
            </ul>
        </div>

        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <h4>Hier worden producten getoond waar u op geboden heeft. De prijs die getoond wordt is uw laatste bod,
                deze is rood wanneer u overgeboden bent.</h4>
        </div>

        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">


            <?php
            searchMyBids($dbh, 0); //Niet gewonnen
            ?>
        </div>

        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <h4>Hier worden producten getoond die u gewonnen heeft! De verkoper neemt zo snel mogelijk contact met u
                op.</h4>
        </div>

        <div class="uk-grid uk-align-center uk-card-refactor2  uk-flex uk-flex-center auctions-reset-margin">
            <?php
            searchMyBids($dbh, 1); //Gewonnen
            ?>
        </div>
    </div>
    <?php
} else {
    header('Location: login.php?');
}
include('scripts/footer.php');

//haal veilingen op waar je op geboden hebt.
function searchMyBids($dbh, $status)
{
    $searchItems = "";

    $queries['search'] = "SELECT voorwerpnummer, titel, looptijdEindmoment, (SELECT TOP 1 filenaam FROM bestand f WHERE v.voorwerpnummer = f.voorwerp) AS bestandsnaam , MAX(Bodbedrag) AS hoogsteBod, CURRENT_TIMESTAMP AS serverTijd
                          FROM Voorwerp v 
                          FULL OUTER JOIN Bod b ON v.voorwerpnummer = b.voorwerp 
                          JOIN VoorwerpInRubriek r ON v.voorwerpnummer = r.voorwerp join Gebruiker g on g.gebruikersnaam = v.verkoper
                          WHERE b.gebruiker LIKE :bindvalue AND v.veilinggesloten = :status   
                          GROUP BY b.voorwerp , Voorwerpnummer, titel, looptijdEindmoment ORDER BY titel; 
";
    $bindValue = $_SESSION['username'];
    $searchItems .= getMyBids($dbh, $queries['search'], $bindValue, $status);
    echo $searchItems;
}

//maakt itemcards van de opgehaalde veilingen
function getMyBids($dbh, $query, $bindvalue, $won)
{
    $itemCards = "";
    try {
        $stmt = $dbh->prepare($query); /* prepared statement */
        $stmt->bindValue(":bindvalue", $bindvalue, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->bindValue(":status", $won, PDO::PARAM_INT);
        $stmt->execute(); /* stuurt alles naar de server */
        $count = $stmt->rowCount();
        if ($count == 0) {
            if (!$won) {
                echo '<div class="uk-alert-warning uk-margin-remove-left"><h2 class="uk-alert-warning">U heeft nog niet geboden op een voorwerp.</h2><h3><a href="index.php">zoek een leuke veiling!</a></h3 class="uk-alert-warning"></div>';
            } else {
                echo '<div class="uk-alert-warning uk-margin-remove-left"><h2 class="uk-alert-warning">U heeft nog geen voorwerpen gewonnen.</h2><h3>Blijf bieden op een voorwerp om te winnen!</h3 class="uk-alert-warning"></div>';
            }
        }
        while ($results = $stmt->fetch()) {
            $price = $results['hoogsteBod'];
            if (is_null($price)) {
                $price = getStartPrice($dbh, $results['voorwerpnummer']);
            }
            $itemCards .= createMyBids($results['titel'], $results['looptijdEindmoment'], $results['bestandsnaam'], $price, $results['voorwerpnummer'], $dbh);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

    return $itemCards;
}