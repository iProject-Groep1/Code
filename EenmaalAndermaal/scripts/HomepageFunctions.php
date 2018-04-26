<?php

//$timerStarted = false;

//function calcNewEndTime($days, $hours, $minutes, $seconds)
//{
////    global $timerStarted;
//    $timerStarted = false;
//
//    $daysModify = $days;
//    $hoursModify = $hours + 2;
//    $minutesModify = $minutes;
//    $secondsModify = $seconds;
//
//    if(!$timerStarted) {
//
//        $tijd = new DateTime(gmdate("Y-m-d\TH:i:s\Z"));
//        $tijd->modify(
//            '+' . $daysModify . 'days' .
//            '+' . $hoursModify . 'hours' .
//            '+' . $minutesModify . 'minutes' .
//            '+' . $secondsModify . 'seconds');
//        $timerStarted = true;
//        return $tijd->format("Y-m-d H:i:s");
//
//    }
//
//    // Als de veilingt tijd (afgelopen) == de tijd op dit moment, oftewel als de timer op 0 staat. DAN
//    if (calcEndTime($daysModify, $hoursModify, $minutesModify, $secondsModify) == gmdate("Y-m-d\TH:i:s\Z") && $timerStarted) {
//        $timerStarted = false;
//    }
//}
//
//
//function calcEndTime($days, $hours, $minutes, $seconds)
//{
//    $daysModify = $days;
//    $hoursModify = $hours + 2;
//    $minutesModify = $minutes;
//    $secondsModify = $seconds;
//
//    $tijd = new DateTime(gmdate("Y-m-d\TH:i:s\Z"));
//    $tijd->modify(
//        '+' . $daysModify . 'days' .
//        '+' . $hoursModify . 'hours' .
//        '+' . $minutesModify . 'minutes' .
//        '+' . $secondsModify . 'seconds');
//    return $tijd->format("Y-m-d H:i:s");
//
//}

require_once('database-connect.php');


function makeTimeSyntax ($dbh, $calcTime ) {

    $time = implode(",", $calcTime);
    return $time;
}


function calcAuctionTime($dbh, $id){

    try {
        if (strlen($id) < 1) {
            return false;
        }

        $stmt = $dbh->prepare("SELECT LooptijdEindMoment FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        $results = $stmt->fetch(PDO::FETCH_ASSOC); /* fetcht de data, hij haalt de gevraagde data op niet 0,1,2etc. maar title, duration etc.*/

        return $results;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}


function checkAuctionStatus($dbh, $id){

    try {
        if (strlen($id) < 1) {
            return false;
        }

        $stmt = $dbh->prepare("SELECT Veilinggesloten FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        $results = $stmt->fetch(PDO::FETCH_ASSOC); /* fetcht de data, hij haalt de gevraagde data op niet 0,1,2etc. maar title, duration etc.*/

        return $results;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
    }

}






