<?php
include('database-connect.php');
session_start();
$username = htmlentities($_SESSION['username'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$firstname = htmlentities($_POST['firstname'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$lastname = htmlentities($_POST['lastname'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$birthday = $_POST['birthday'];
$adres1 = htmlentities($_POST['adres1'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$postalCode = htmlentities($_POST['postalCode'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$placeName = htmlentities($_POST['placeName'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$country = htmlentities($_POST['country'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

if (empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($birthday)) || empty(trim($adres1)) || empty(trim($postalCode)) || empty(trim($placeName)) || empty(trim($country))) {
    $_SESSION['noChance'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Er zijn geen gegevens veranderd.\', status: \'danger\'})</script>';
    header('Location: ../profile.php?');
} else {
    try{
        $stmt = $dbh->prepare("UPDATE Gebruiker SET voornaam = :voornaam, achternaam= :achternaam, geboortedag = :geboortedag, adresregel1 = :adres1, postcode = :postcode, plaatsnaam = :plaatsnaam, land = :land WHERE gebruikersnaam = :gebruikersnaam");
        $stmt->bindValue(":voornaam", $firstname, PDO::PARAM_STR);
        $stmt->bindValue(":achternaam", $lastname, PDO::PARAM_STR);
        $stmt->bindValue(":geboortedag", $birthday, PDO::PARAM_STR);
        $stmt->bindValue(":adres1", $adres1, PDO::PARAM_STR);
        $stmt->bindValue(":postcode", $postalCode, PDO::PARAM_STR);
        $stmt->bindValue(":plaatsnaam", $placeName, PDO::PARAM_STR);
        $stmt->bindValue(":land", $country, PDO::PARAM_STR);
        $stmt->bindValue(":gebruikersnaam", $username, PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION['chance'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> Uw gegevens zijn veranderd.\', status: \'success\'})</script>';
        header('Location: ../profile.php?');
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
}





