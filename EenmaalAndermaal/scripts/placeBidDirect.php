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

} else if ($Login == true) {

    if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['bedrag']) && !empty($_GET['bedrag'])) {
        // Verify data
        $id = $_GET['id']; // Set id variable
        $bedrag = $_GET['bedrag']; //Set bedrag variable
        setMinBid($dbh, $id, $bedrag);
    }


    function setMinBid($dbh, $id, $bedrag)
    {
        $bodbedrag = $bedrag;
        $gebruiker = $_SESSION['username'];
        $bodtijd = getServerTime($dbh);

        try {
            $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
            $query = $dbh->prepare($sql);
            $query->execute(array($id, $bodbedrag, $gebruiker, $bodtijd));
            echo "bod is geplaatst";
            header('Location:../detailpage.php?id=' . $id . '');
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }

    }
}