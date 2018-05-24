<?php

include('database-connect.php');

if (isset($_SESSION['username'])) {
    if (in_array($_SESSION['username'], makeArrayBidders($dbh))) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            sendMessage($dbh, $id);
        }
    }
}

function getHighestBidder($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("select top 1 MAX(bodbedrag) as hoogsteBod, gebruiker from bod where voorwerp = :Voorwerpnummer group by gebruiker order by hoogsteBod desc"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        if ($results = $stmt->fetch()) {
            $row = $results['gebruiker'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }

}

function makeArrayBidders($dbh)
{
    $array = [];
    $objectNumber = $_GET('id');
    try {
        $stmt = $dbh->prepare("SELECT bodbedrag, gebruiker FROM dbo.Bod WHERE voorwerp = :voorwerp ORDER BY bodbedrag DESC");
        $stmt->bindValue(":voorwerp", $objectNumber, PDO::PARAM_STR);
        $stmt->execute();
        $i = 0;
        while ($results = $stmt->fetch()) {
            $array[$i] = $results['gebruiker'];
            $i++;
        }
        return $array;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        die();
        header('Location: errorpage.php?err=500');

    }
}

function sendMessage($dbh, $id)
{
    $hoogsteBieder = getHighestBidder($dbh, $id);

    if (isset($_SESSION['username'])) {
        if ($hoogsteBieder != $_SESSION['username']) {
            $_SESSION['overBidMelding'] = '
                <script>UIkit.notification({message: \' <span uk-icon="icon: mail"></span> U bent overgeboden door: ' . $hoogsteBieder . ' bij <a href="detailpage.php?id=' . $id . '"> deze </a> veiling \', status: \'danger\'})</script>';
        }
    }
}