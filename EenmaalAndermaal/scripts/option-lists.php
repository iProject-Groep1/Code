<?php
include('database-connect.php');

//haal een optielijst van betaalwijzen op.
function getPaymentMethodList($dbh)
{
    $return = '';
    try {
        $stmt = $dbh->prepare("SELECT betaalwijze FROM Betaalwijze"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()) {
            $return .= '<option value="' . $row['betaalwijze'] . '"> ' . $row['betaalwijze'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    return $return;
}

//haal een optielijst met geheime vragen op.
function getRecoveryQuesionList($dbh)
{
    $return = '';
    try {
        $stmt = $dbh->prepare("SELECT [vraagnummer], [vraagtekst] FROM Vraag"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()) {
            $return .= '<option value="' . $row ['vraagnummer'] . '"> ' . $row['vraagtekst'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    return $return;
}

//haal een optielijst met landen op.
function getCountryList($dbh)
{
    $return = '';
    try {
        $stmt = $dbh->prepare("SELECT land FROM land"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()) {
            $return .= '<option value="' . $row['land'] . '"> ' . $row['land'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    return $return;
}

//haalt een optielijst met tijden op.
function getAuctionLengths($dbh)
{
    $return = '';
    try {
        $stmt = $dbh->prepare("SELECT dagen FROM looptijd"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()) {
            if ($row['dagen'] != 7) {
                $return .= '<option value="' . $row['dagen'] . '"> ' . $row['dagen'] . '</option>';
            } else {
                $return .= '<option value="' . $row['dagen'] . '" selected> ' . $row['dagen'] . '</option>';
            }
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    return $return;
}