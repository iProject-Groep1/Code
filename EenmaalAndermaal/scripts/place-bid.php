<?php
session_start();
include('database-connect.php');
include('bid-functions.php');
include('homepage-functions.php');
include('login-functions.php');

$Login = CheckLogin ();
if ($Login == false) {
    $_SESSION['LogMelding'] = '
    <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: sign-in"></span> U moet inloggen om een bod te plaatsen.\', status: \'danger\'})</script>
    ';

    header("Location: ../login.php");


} else {
    if (getSeller($dbh, $_GET['id']) == $_SESSION['username']) {
        $_SESSION['bodMelding'] = '
        <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: close"></span> U mag niet up uw eigen veiling bieden!\', status: \'danger\'})</script>
';
        header('Location:../detailpage.php?id=' . $_GET['id']);
    } else {

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Verify data
            $id = $_GET['id']; // Set email variable
            setMinBid($dbh, $id);
        }
    }
}

function setMinBid($dbh, $id)
{
    $bodbedrag = calcMinBid($dbh, $id);
    $gebruiker = htmlentities($_SESSION['username'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
    $bodtijd = getServerTime($dbh);

    try {
        $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?, ?,?,?)"; /* prepared statement */
        $query = $dbh->prepare($sql);
        $query->execute(array($id, $bodbedrag, $gebruiker, $bodtijd));
        $_SESSION['bodMelding'] = '
            <script style="border-radius: 25px;">UIkit.notification({message: \'<span uk-icon="icon: check"></span> Uw bod van €' . $bodbedrag . ' is geplaatst.\', status: \'success\'})</script>
';
        header('Location:../detailpage.php?id=' . $id . '');

    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }

}