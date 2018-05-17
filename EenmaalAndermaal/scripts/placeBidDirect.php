<?php
session_start();
include('database-connect.php');
include('bid-functions.php');
include('homepage-functions.php');
include('login-functions.php');

if (!CheckLogin()) {
    $_SESSION['LogMelding'] = '
<script>UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> U moet inloggen om een bod te plaatsen.\', status: \'danger\'})</script>
';

    header("Location: ../login.php");

} else {

    if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['bedrag']) && !empty($_GET['bedrag'])) {
        // Verify data
        $id = $_GET['id']; // Set id variable
        $bedrag = $_GET['bedrag']; //Set bedrag variable
        setMinBid($dbh, $id, $bedrag);
    } else if (empty($_GET['bedrag'])) {
        $_SESSION['bodMelding'] = '
        <script>UIkit.notification({message: \'<span uk-icon="icon: close"></span> Vul een bodbedrag in!\', status: \'danger\'})</script>
';
        header('Location:../detailpage.php?id=' . $_GET['id']);
    }

}

function setMinBid($dbh, $id, $bedrag)
{
    $bodbedrag = $bedrag;
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);
    $minBod = calcMinBid($dbh, $id);
    $maxBodBedrag = 2147483647;

    if ($bedrag >= $maxBodBedrag) {
        $_SESSION['bodMelding'] = '
        <script>UIkit.notification({message: \'<span uk-icon="icon: close"></span> Het bodbedrag moet minder dan'. $maxBodBedrag .'.\', status: \'danger\'})</script>
        ';
        header('Location:../detailpage.php?id=' . $id . '');
    } else if ($bedrag >= calcMinBid($dbh, $id)) {
        try {
            $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
            $query = $dbh->prepare($sql);
            $query->execute(array($id, $bodbedrag, $gebruiker, $bodtijd));
            $_SESSION['bodMelding'] = '
            <script>UIkit.notification({message: \'<span uk-icon="icon: check"></span> Uw bod van €' . $bedrag . ' is geplaatst.\', status: \'success\'})</script>
';
            header('Location:../detailpage.php?id=' . $id . '');

        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }

    } else {
        $_SESSION['bodMelding'] = '
        <script>UIkit.notification({message: \'<span uk-icon="icon: close"> </span> Het bodbedrag moet minimaal €' . $minBod . ' zijn.\', status: \'danger\'})</script>
';
        header('Location:../detailpage.php?id=' . $id . '');
    }
}