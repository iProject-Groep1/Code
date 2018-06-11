<?php

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