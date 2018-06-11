<?php
include('database-connect.php');

function Get_payment($dbh)
{
    $return = '';
    try {
        $stmt = $dbh->prepare("select betaalwijze from Betaalwijze"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()) {
            $return .= '<option value="' . $row['betaalwijze'] . '"> ' . $row['betaalwijze'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    return $return;
}

function Get_question($dbh){
    $return = '';
    try {
        $stmt = $dbh->prepare("select [vraagnummer], [vraagtekst] from Vraag"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()){
            $return .= '<option value="'. $row ['vraagnummer'] .'"> '.$row['vraagtekst'].'</option>';
        }
    }
    catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    return $return;
}

function Get_country($dbh)
{
    $return = '';
    try {
        $stmt = $dbh->prepare("select land from land"); /* prepared statement */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($row = $stmt->fetch()) {
            $return .= '<option value="' . $row['land'] . '"> ' . $row['land'] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }
    return $return;
}