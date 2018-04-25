<?php

//$timerStarted = false;

function calcNewEndTime($days, $hours, $minutes, $seconds)
{
//    global $timerStarted;
    $timerStarted = false;

    $daysModify = $days;
    $hoursModify = $hours + 2;
    $minutesModify = $minutes;
    $secondsModify = $seconds;

    if(!$timerStarted) {

        $tijd = new DateTime(gmdate("Y-m-d\TH:i:s\Z"));
        $tijd->modify(
            '+' . $daysModify . 'days' .
            '+' . $hoursModify . 'hours' .
            '+' . $minutesModify . 'minutes' .
            '+' . $secondsModify . 'seconds');
        $timerStarted = true;
        return $tijd->format("Y-m-d H:i:s");

    }

    // Als de veilingt tijd (afgelopen) == de tijd op dit moment, oftewel als de timer op 0 staat. DAN
    if (calcEndTime($daysModify, $hoursModify, $minutesModify, $secondsModify) == gmdate("Y-m-d\TH:i:s\Z") && $timerStarted) {
        $timerStarted = false;
    }
}


function calcEndTime($days, $hours, $minutes, $seconds)
{
    $daysModify = $days;
    $hoursModify = $hours + 2;
    $minutesModify = $minutes;
    $secondsModify = $seconds;

    $tijd = new DateTime(gmdate("Y-m-d\TH:i:s\Z"));
    $tijd->modify(
        '+' . $daysModify . 'days' .
        '+' . $hoursModify . 'hours' .
        '+' . $minutesModify . 'minutes' .
        '+' . $secondsModify . 'seconds');
    return $tijd->format("Y-m-d H:i:s");

}







