<?php
$pageTitle = "Mijn Profiel";
require('scripts/header.php');
include('scripts/database-connect.php');


if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {

    //haal bijna alle informatie van een gebruiker op
//TODO query aanpassen zodat gemiddelde feedback en telefoonnummers mee wordt genomen.
    $data = "";
    try {
        $stmt = $dbh->prepare("SELECT gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mail_adres, verkoper FROM gebruiker WHERE gebruikersnaam LIKE :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }

    ?>

    <h1 class="uk-text-center">Mijn Profiel</h1>
    <div>
    <div class="">
        <ul class="uk-nav-default uk-nav-parent-icon uk-nav" uk-nav="">

            <li class="uk-parent uk-open">
                <a href="#">EenmaalAndermaal</a>
                <ul class="uk-nav-sub" aria-hidden="false">
                    <li"><a href="profile.php">Mijn Profiel</a></li>
                    <li><a href="">Gegevens wijzigen</a></li>
                    <li>
                        <a href="#">Mijn Veilingen</a>

                    </li>
                    <li> <a href="#">Mijn Biedingen</a></li>

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
                    <td><p class="uk-text-center"><?=$data['gebruikersnaam']?></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="uk-width-1-3">Accounttype:</td>
                    <td><p class="uk-text-center"><?php if($data['verkoper'] == 1){echo "Verkoper";} else if($data['verkoper'] == 0){
                        echo "Gebruiker";
                        }?></p></td>
                </tr>
                <!-- TODO: rating -->
                <?php
                if($data['verkoper'] == 1){
                    ?>
                    <tr>
                        <td class="uk-table-shrink"><span uk-icon="happy"></span></td>
                        <td class="uk-width-1-3">Accounttype:</td>
                        <td><p class="uk-text-center"></p></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td class="uk-table-shrink"><span uk-icon="clock"></span></td>
                    <td class="uk-width-1-3">Geboortedatum:</td>
                    <td><p class="uk-text-center"><?=date('d-m-Y',strtotime($data['geboortedag']))?></p></td>
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
                    <td><p class="uk-text-center"><?= $data['mail_adres']?></p></td>
                </tr>
                <tr>
                    <td class="uk-table-shrink"><span uk-icon="location"></span></td>
                    <td class="uk-width-1-3"><p>Adres:</p></td>
                    <td><p class="uk-text-center"><?=$data['adresregel1']?></p></td>
                </tr>
                <?php
                if(!empty($data['adresregel2'])){
                    ?>
                    <tr>
                        <td></td>
                        <td><p></p></td>
                        <td><p class="uk-text-center"><?=$data['adresregel2']?></p></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><p class="uk-text-center"><?= strtoupper($data['postcode']) . " " . $data['plaatsnaam']?></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><p class="uk-text-center"><?= $data['land']?></p></td>
                </tr>

                <!--TODO: telefoonnummers -->


                </tbody>
            </table>
        </div>
        <div class="uk-flex uk-flex-row uk-flex-around">
            <a class="uk-button uk-button-primary" href="">Wijzig gegevens</a>
            <a class="uk-button uk-button-primary" href="">Wijzig wachtwoord</a>
            <!-- knoppen -->
        </div>
    </div>
    </div>

    <?php

} else {
    //TODO netjes naar inlogpagina sturen met melding "u moet inloggen".
    header('Location: errorpage.php?err=404');

}


include('scripts/footer.php');