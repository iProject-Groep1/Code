<?php
session_start();
include('database-connect.php');

if(isset($_POST['submit'])){
    insertItem($dbh);
}

function insertItem($dbh)
{
    try {
        $stmt = $dbh->prepare("SELECT gebruikersnaam, telefoon, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mail_adres, verkoper FROM gebruiker LEFT JOIN gebruikerstelefoon on gebruikersnaam = gebruiker WHERE gebruikersnaam LIKE :gebruikersnaam ORDER BY volgnr");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }


    $rubrieknr = $_POST['Rubrieknr'];
    $titel = $_POST['Titel'];
    $startprijs = $_POST['Startprijs'];
    $verzendkosten = $_POST['Verzendkosten'];
    $betalingswijze = $_POST['Betalingswijze'];
    $veilingtijd =  $_POST['Veilingtijd'];
    $beschrijving = $_POST['Beschrijving'];
    $plaatsnaam = $data['plaatsnaam'];
    $land = $data['land'];
    $verkoper = $_SESSION['username'];

    try {
        $sql = "SET NOCOUNT ON; insert into
 voorwerp(  [titel]
           ,[beschrijving]
           ,[startprijs]
           ,[betalingswijze]
           ,[betalingsinstructie]
           ,[plaatsnaam]
           ,[land]
           ,[looptijd]
           ,[verzendkosten]
           ,[verzendinstructies]
           ,[verkoper])
        values (?,?,?,?,?,?,?,?,?,?,?); select scope_identity() as lastid";

        $query = $dbh->prepare($sql);
        $query->execute(array($titel, $beschrijving, $startprijs, $betalingswijze,'Na betaling wordt het product verzonden.', $plaatsnaam, $land, $veilingtijd, $verzendkosten, 'test', $verkoper));
        while ($results = $query->fetch()){
            $lastid = $results["lastid"];
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        $_SESSION['fillEverything'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Vul aub alle gegevens in! \', status: \'success\'})</script>';
        header('Location: ../upload.php?Rubriek='. $titel .'&Rubrieknr='.$rubrieknr.'.php');
    }

    uploadPicture ($lastid, $dbh, $rubrieknr, $titel);
}

function uploadPicture ($lastid, $dbh, $rubrieknr, $titel){
    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["Image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["Image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    /*
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    */

// Check file size
    if ($_FILES["Image"]["size"] > 500000) {
        $_SESSION['fillEverything2'] .= '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Sorry, uw plaatje is te groot.. \', status: \'danger\'})</script>';
        header('Location: ../search-Rubriek.php');
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $_SESSION['fillEverything2'] .= '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span> Sorry, wij accepteren alleen JPG, JPEG, PNG & GIF files. \', status: \'danger\'})</script>';
        header('Location: ../search-Rubriek.php');
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {


            try {
                $sql = "insert into VoorwerpInRubriek ([voorwerp],[rubriek_op_laagste_Niveau])
        values (?,?)";

                $query = $dbh->prepare($sql);
                $query->execute(array($lastid, $rubrieknr));
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
                $_SESSION['fillEverything'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Vul aub alle gegevens in! \', status: \'danger\'})</script>';
                header('Location: ../upload.php?Rubriek='. $titel .'&Rubrieknr='.$rubrieknr.'.php');
            }

            try {
                $sql = "insert into Bestand ([filenaam],[voorwerp])
        values (?,?)";

                $query = $dbh->prepare($sql);
                $query->execute(array('http://iproject1.icasites.nl/upload/'.$_FILES["Image"]["name"].'',$lastid));
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
                $_SESSION['fillEverything2'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Dit plaatje voldoet helaas niet aan de eisen. \', status: \'danger\'})</script>';
                header('Location: ../search-Rubriek.php');
            }
            echo "The file ". basename( $_FILES["Image"]["name"]). " has been uploaded.";
            header('Location: ../detailpage.php?id=' . $lastid . '');
        } else {
            echo "Sorry, there was an error uploading your file.";
            $_SESSION['fillEverything2'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Dit plaatje voldoet helaas niet aan de eisen. \', status: \'danger\'})</script>';
            header('Location: ../search-Rubriek.php');
        }
    }
}
