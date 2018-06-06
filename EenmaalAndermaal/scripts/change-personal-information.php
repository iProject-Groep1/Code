<?php
include('database-connect.php');
session_start();
$username = $_SESSION['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$adres1 = $_POST['adres1'];
$postalCode = $_POST['postalCode'];
$placeName = $_POST['placeName'];
$country = $_POST['country'];

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





