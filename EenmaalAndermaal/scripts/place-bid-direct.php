<?php
session_start();
include('database-connect.php');
include('bid-functions.php');
include('homepage-functions.php');
include('login-functions.php');


$Login = CheckLogin ();
if ($Login == false) {
    $_SESSION['LogMelding'] = '
<script>UIkit.notification({message: \'Log in first please\', status: \'danger\'})</script>
';

    header("Location: ../login.php");

} else {

    if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['bedrag']) && !empty($_GET['bedrag'])) {
        // Verify data
        $id = $_GET['id']; // Set id variable
        $bedrag = $_GET['bedrag']; //Set bedrag variable
        setMinBid($dbh, $id, $bedrag);
    }

}

function setMinBid($dbh, $id, $bedrag)
{
    $bodbedrag = $bedrag;
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);
    $minBod = calcMinBid($dbh, $id);

<<<<<<< HEAD:EenmaalAndermaal/scripts/place-bid-direct.php
    if ($bedrag >= $maxBodBedrag) {
        $_SESSION['bodMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> Het bodbedrag moet minder dan'. $maxBodBedrag .'.\', status: \'danger\'})</script>
        ';
        header('Location:../detailpage.php?id=' . $id . '');
    } else if ($bedrag >= $minBod) {
=======
    if($bedrag > calcMinBid($dbh, $id)) {
>>>>>>> ae531bcc34fe862ba88da01106603c0eaea8255f:EenmaalAndermaal/scripts/placeBidDirect.php
        try {
            $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
            $query = $dbh->prepare($sql);
            $query->execute(array($id, $bodbedrag, $gebruiker, $bodtijd));
            header('Location:../detailpage.php?id=' . $id . '');
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }
    } else {
        $_SESSION['bodMelding'] = '
<script>UIkit.notification({message: \'Het bod moet minimaal '. $minBod .' zijn\', status: \'danger\'})</script>
';
        header('Location:../detailpage.php?id=' . $id . '');
    }

}