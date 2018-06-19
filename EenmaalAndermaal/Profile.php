<?php
$pageTitle = "Mijn Profiel";
require('scripts/header.php');
include('scripts/database-connect.php');

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
    //haal alle informatie van een gebruiker op
    $data = "";
    try {
        $stmt = $dbh->prepare("  SELECT  g.gebruikersnaam, telefoon, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mail_adres, verkoper, rating 
                                          FROM gebruiker g 
                                          LEFT JOIN gebruikerstelefoon ON gebruikersnaam = gebruiker 
                                          LEFT JOIN verkoper v ON g.gebruikersnaam = v.gebruikersnaam 
                                          WHERE g.gebruikersnaam LIKE :gebruikersnaam  
                                          ORDER BY volgnr");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    ?>
    <h2 class="uk-text-center">Mijn Profiel</h2>
    <div class="uk-margin-left@l uk-margin-left@m">

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

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@s uk-width-1-3@m uk-margin-auto uk-flex uk-flex-column uk-flex-wrap-around uk-margin-medium-top uk-margin-large-bottom">
            <div class="uk-overflow-auto">
                <!-- gebruikersinformatie -->
                <h3 class="uk-card-title uk-text-center">Gebruikersinformatie</h3>
                <table class="uk-table uk-table-hover uk-table-justify uk-table-small">
                    <tbody>
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="user"></span></td>
                        <td class="uk-width-1-3"><p>Naam:</p></td>
                        <td><p class="uk-text-center"><?= $data['voornaam'] . " " . $data['achternaam'] ?></p></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="uk-width-1-3"><p>Gebruikersnaam:</p></td>
                        <td><p class="uk-text-center"><?= $data['gebruikersnaam'] ?></p></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="uk-width-1-3">Accounttype:</td>
                        <td><p class="uk-text-center"><?php if ($data['verkoper'] == 1) {
                                    echo 'Verkoper';
                                } else if ($data['verkoper'] == 0) {
                                    echo 'Gebruiker <a href="become-seller.php" class="uk-icon-link uk-margin-small-right" uk-icon="tag" uk-tooltip="Verkoper worden?"></a>';
                                } ?></p></td>
                    </tr>

                    <?php
                    if ($data['verkoper'] == 1) {
                        ?>
                        <tr>
                            <td class="uk-table-shrink"><span uk-icon="happy"></span></td>
                            <td class="uk-width-1-3">Waardering:</td>
                            <td><p class="uk-text-center"><?php
                                    $numberOfStars = (int)$data['rating'] /= 20;
                                    for ($i = 0; $i < $numberOfStars; $i++) {
                                        ?>
                                        <span uk-icon="star" class="rating-star"></span>
                                        <?php
                                    }
                                    for ($i = 0; $i < 5 - $numberOfStars; $i++) {
                                        ?>
                                        <span uk-icon="star"></span>
                                        <?php
                                    }

                                    ?>
                                </p></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="clock"></span></td>
                        <td class="uk-width-1-3">Geboortedatum:</td>
                        <td><p class="uk-text-center"><?= date('d-m-Y', strtotime($data['geboortedag'])) ?></p></td>
                    </tr>

                    </tbody>
                </table>

            </div>
            <div class="uk-overflow-auto">
                <!-- contactinformatie -->
                <h3 class="uk-card-title uk-text-center">Contactinformatie</h3>
                <table class="uk-table uk-table-hover uk-table-justify uk-table-small">
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="mail"></span></td>
                        <td class="uk-width-1-3"><p>E-mailadres:</p></td>
                        <td><p class="uk-text-center"><?= $data['mail_adres'] ?></p></td>
                    </tr>
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="home"></span></td>
                        <td class="uk-width-1-3"><p>Adres:</p></td>
                        <td><p class="uk-text-center"><?= $data['adresregel1'] ?></p></td>
                    </tr>
                    <?php
                    if (!empty($data['adresregel2'])) {
                        ?>
                        <tr>
                            <td></td>
                            <td><p></p></td>
                            <td><p class="uk-text-center"><?= $data['adresregel2'] ?></p></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="location"></span></td>
                        <td class="uk-width-1-3"><p>Postode:</p></td>
                        <td>
                            <p class="uk-text-center"><?= strtoupper($data['postcode']) . " " . $data['plaatsnaam'] ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="world"></span></td>
                        <td class="uk-width-1-3"><p>Land:</p></td>
                        <td><p class="uk-text-center"><?= $data['land'] ?></p></td>
                    </tr>

                    <?php if (!empty($data['telefoon'])) { ?>
                        <tr>
                            <td class="uk-table-shrink"><span uk-icon="receiver"></span></td>
                            <td class="uk-width-1-3">Telefoonnummer(s)</td>
                            <td><p class="uk-text-center"><?= $data['telefoon'] ?></p></td>
                        </tr>
                        <?php
                    }
                    while ($data = $stmt->fetch()) {
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><p class="uk-text-center"><?= $data['telefoon'] ?></p></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>

            <div class="uk-flex uk-flex-row uk-flex-around">
                <!-- knoppen -->
                <a class="uk-button uk-button-primary" href="change-profile.php">Wijzig gegevens</a>
                <a class="uk-button uk-button-primary" href="change-password.php">Wijzig wachtwoord</a>

            </div>
        </div>
    </div>
    <?php
} else {
    header('Location: login.php?');
}
include('scripts/footer.php');