<?php


function getPaymentMethodList($dbh){
    $paymentMethodList = '';
    try {
        $stmt = $dbh->prepare("SELECT Betaalwijze FROM Betaalwijze"); /* prepared statement */
        $stmt->execute();
        while ($row = $stmt->fetch()){
            $paymentMethodList .= '<option value="' . $row['Betaalwijze'] . '">' . $row['Betaalwijze'] . '</option>';
        }
    }
    catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    return $paymentMethodList;
}