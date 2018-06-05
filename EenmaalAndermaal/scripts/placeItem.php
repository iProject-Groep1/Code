<?php
session_start();
include('database-connect.php');

if(isset($_POST['submit'])){
    insertItem($dbh);
}

function insertItem($dbh)
{
    $rubrieknr = $_POST['Rubrieknr'];
    $titel = $_POST['Titel'];
    $startprijs = $_POST['Startprijs'];
    $verzendkosten = $_POST['Verzendkosten'];
    $betalingswijze = $_POST['Betalingswijze'];
    $veilingtijd =  $_POST['Veilingtijd'];
    $beschrijving = $_POST['Beschrijving'];
    $plaatsnaam = 'TestlandTim';
    $land = 'TestlandTim';
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
        die();
        header('Location: errorpage.php?err=500');
    }


    try {
        $sql = "insert into VoorwerpInRubriek ([voorwerp],[rubriek_op_laagste_Niveau])
        values (?,?)";

        $query = $dbh->prepare($sql);
        $query->execute(array($lastid, $rubrieknr));
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        die();
        header('Location: errorpage.php?err=500');
    }

    uploadPicture ($lastid, $dbh);
}

function uploadPicture ($lastid, $dbh){
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
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["Image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {

            try {
                $sql = "insert into Bestand ([filenaam],[voorwerp])
        values (?,?)";

                $query = $dbh->prepare($sql);
                $query->execute(array('http://iproject1.icasites.nl/upload/'.$_FILES["Image"]["name"].'',$lastid));
            } catch (PDOException $e) {
                echo "Fout" . $e->getMessage();
                die();
                header('Location: errorpage.php?err=500');
            }
            echo "The file ". basename( $_FILES["Image"]["name"]). " has been uploaded.";
            header('Location: ../detailpage.php?id=' . $lastid . '');
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
