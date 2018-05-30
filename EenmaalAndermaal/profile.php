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
    <div class="uk-card uk-card-default uk-card-body">
        <div>
            <!-- gebruikersinformatie -->
            <h3 class="uk-card-title uk-text-center">Gebruikersinformatie</h3>
            <table class="uk-table">
                <tbody>
                <tr>
                    <td><span uk-icon="user"></span></td>
                    <td><p>Naam:</p></td>
                    <td><p><?= $data['voornaam'] . " " . $data['achternaam'] ?></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td><p>Gebruikersnaam:</p></td>
                    <td><p><?=$data['gebruikersnaam']?></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Accounttype:</td>
                    <td><p><?php if($data['verkoper'] == 1){echo "Verkoper";} else if($data['verkoper'] == 0){
                        echo "Gebruiker";
                        }?></p></td>
                </tr>
                <!-- TODO: rating -->
                <?php
                if($data['verkoper'] == 1){
                    ?>
                    <tr>
                        <td><span uk-icon="happy"></span></td>
                        <td>Accounttype:</td>
                        <td><p><?php if($data['verkoper'] == 1){echo "Verkoper";} else if($data['verkoper'] == 0){
                                    echo "Gebruiker";
                                }?></p></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>
        <div>
            <!-- contactinformatie -->
        </div>
        <div>
            <!-- knoppen -->
        </div>
    </div>


    <?php

} else {
    header('Location: errorpage.php?err=404');

}


include('scripts/footer.php');