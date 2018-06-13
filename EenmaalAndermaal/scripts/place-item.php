<?php
session_start();
include('database-connect.php');

if (isset($_POST['submit'])) {
    insertItem($dbh);
}

//voegt veiling toe.
function insertItem($dbh)
{
//    echo '<pre>';
//    print_r($_FILES);
//    echo '</pre>';
    die();
    //haal plaatsnaam en land op.
    try {
        $stmt = $dbh->prepare("SELECT plaatsnaam, land FROM gebruiker WHERE gebruikersnaam LIKE :gebruikersnaam");
        $stmt->bindValue(":gebruikersnaam", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }

    //schoon alle invoer op.
    $rubrieknr = htmlentities($_POST['Rubrieknr'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $titel = htmlentities($_POST['Titel'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $startprijs = htmlentities($_POST['Startprijs'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $verzendkosten = htmlentities($_POST['Verzendkosten'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $betalingswijze = htmlentities($_POST['Betalingswijze'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $veilingtijd = htmlentities($_POST['Veilingtijd'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $beschrijving = htmlentities($_POST['Beschrijving'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $plaatsnaam = htmlentities($data['plaatsnaam'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $land = htmlentities($data['land'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $verkoper = htmlentities($_SESSION['username'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

    try {
        $sql = "SET NOCOUNT ON; 
        INSERT INTO voorwerp(   
                        [titel],
                        [beschrijving],
                        [startprijs],
                        [betalingswijze],
                        [betalingsinstructie],
                        [plaatsnaam],
                        [land],
                        [looptijd],
                        [verzendkosten],
                        [verzendinstructies],
                        [verkoper])
        VALUES (?,?,?,?,?,?,?,?,?,?,?); 
        SELECT scope_identity() AS lastid";
        $query = $dbh->prepare($sql);
        $query->execute(array($titel, $beschrijving, $startprijs, $betalingswijze, 'Na betaling wordt het product verzonden.', $plaatsnaam, $land, $veilingtijd, $verzendkosten, 'test', $verkoper));
        while ($results = $query->fetch()) {
            $lastid = $results["lastid"];
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        $_SESSION['fillEverything'] = '
        <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Vul aub alle gegevens in! \', status: \'danger\'})</script>';
        header('Location: ../upload.php?Rubriek=' . $titel . '&Rubrieknr=' . $rubrieknr . '.php');
    }
    //TODO: meerdere foto's
    uploadPicture($lastid, $dbh, $rubrieknr, $titel);
}

function uploadPicture($lastid, $dbh, $rubrieknr, $titel)
{
    for ($i = 0; $i < count($_FILES["Image"]["name"]); $i++) {
        $target_dir = "../upload/";
        $target_file = $target_dir . basename($_FILES["Image"]["name"][$i]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //controleer of het wel een foto is.
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["Image"]["tmp_name"][$i]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        //controleer of bestandsnaam te groot is.
        if (strlen($_FILES["Image"]["name"][$i]) > 500) {
            $_SESSION['fillEverything2'] .= '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Sorry, uw plaatjesnaam is te groot.. \', status: \'danger\'})</script>';
            header('Location: ../search-Rubriek.php');
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["Image"]["size"][$i] > 10000000) {
            $_SESSION['fillEverything2'] .= '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Sorry, uw plaatje is te groot.. \', status: \'danger\'})</script>';
            header('Location: ../search-Rubriek.php');
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            $_SESSION['fillEverything2'] .= '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span> Sorry, wij accepteren alleen JPG, JPEG, PNG en GIF files. \', status: \'danger\'})</script>';
            header('Location: ../search-Rubriek.php');
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["Image"]["tmp_name"][$i], $target_file)) {
                try {
                    $sql = "INSERT INTO VoorwerpInRubriek ([voorwerp],[rubriek_op_laagste_Niveau]) VALUES (?,?)";
                    $query = $dbh->prepare($sql);
                    $query->execute(array($lastid, $rubrieknr));
                } catch (PDOException $e) {
                    echo "Fout" . $e->getMessage();
                    $_SESSION['fillEverything'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Vul aub alle gegevens in! \', status: \'danger\'})</script>';
                    header('Location: ../upload.php?Rubriek=' . $titel . '&Rubrieknr=' . $rubrieknr . '.php');
                }
                try {
                    $sql = "INSERT INTO Bestand ([filenaam],[voorwerp]) VALUES (?,?)";
                    $query = $dbh->prepare($sql);
                    $query->execute(array('http://iproject1.icasites.nl/upload/' . $_FILES["Image"]["name"][$i] . '', $lastid));
                } catch (PDOException $e) {
                    echo "Fout" . $e->getMessage();
                    $_SESSION['fillEverything2'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Dit plaatje voldoet helaas niet aan de eisen. \', status: \'danger\'})</script>';
                    header('Location: ../search-Rubriek.php');
                }
                echo "The file " . basename($_FILES["Image"]["name"][$i]) . " has been uploaded.";
                header('Location: ../detailpage.php?id=' . $lastid . '');
            } else {
                echo "Sorry, there was an error uploading your file.";
                $_SESSION['fillEverything2'] = '
            <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span>  Dit plaatje voldoet helaas niet aan de eisen. \', status: \'danger\'})</script>';
                header('Location: ../search-Rubriek.php');
            }
        }
    }
}
