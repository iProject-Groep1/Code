<?php
session_start();
include('database-connect.php');
include('bid-functions.php');
include('homepage-functions.php');
include('login-functions.php');

//controleer of ingelogd is.
if (!CheckLogin()) {
    $_SESSION['LogMelding'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> U moet inloggen om een bod te plaatsen.\', status: \'danger\'})</script>';
    header("Location: ../login.php");

} else {
    //controleer of niet op eigen veiling  geboden is.
    if (getSeller($dbh, $_GET['id']) == $_SESSION['username']) {
        $_SESSION['bodMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> U mag niet up uw eigen veiling bieden!\', status: \'danger\'})</script>';
        header('Location:../detailpage.php?id=' . $_GET['id']);
    } else {
        if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['bedrag']) && !empty($_GET['bedrag'])) {
            // Verify data
            $id = $_GET['id']; // Set id variable
            $bedrag = $_GET['bedrag']; //Set bedrag variable
            insertMinBid($dbh, $id, $bedrag);
        } else if (empty($_GET['bedrag'])) {
            $_SESSION['bodMelding'] = '
            <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> Vul een bodbedrag in!\', status: \'danger\'})</script>';
            header('Location:../detailpage.php?id=' . $_GET['id']);
        }
    }
}

//controleert of bod goed is en slaat deze op.
function insertMinBid($dbh, $id, $bedrag)
{
    $bodbedrag = $bedrag;
    $gebruiker = htmlentities($_SESSION['username'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $bodtijd = getServerTime($dbh);
    $minBod = calcMinBid($dbh, $id);
    $maxBodBedrag = 2147483647;

    if ($bedrag >= $maxBodBedrag) {
        $_SESSION['bodMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> Het bodbedrag moet minder dan '. $maxBodBedrag .' zijn.\', status: \'danger\'})</script>';
        header('Location:../detailpage.php?id=' . $id . '');
    } else if ($bedrag >= calcMinBid($dbh, $id)) {
        try {
            $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
            $query = $dbh->prepare($sql);
            $query->execute(array($id, $bodbedrag, $gebruiker, $bodtijd));
            $_SESSION['bodMelding'] = '
            <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: check"></span> Uw bod van €' . $bedrag . ' is geplaatst.\', status: \'success\'})</script>';
            header('Location:../detailpage.php?id=' . $id . '');
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
            header('Location: errorpage.php?err=500');
        }
    } else {
        $_SESSION['bodMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"> </span> Het bodbedrag moet minimaal €' . $minBod . ' zijn.\', status: \'danger\'})</script>';
        header('Location:../detailpage.php?id=' . $id . '');
    }
}