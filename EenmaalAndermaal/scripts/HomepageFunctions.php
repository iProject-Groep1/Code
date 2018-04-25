<?php

function calcEndTime($days, $hours, $minutes, $seconds)
{
    $daysModify = $days;
    $hoursModify = $hours + 2;
    $minutesModify = $minutes;
    $secondsModify = $seconds;

    $tijd = new DateTime(gmdate("Y-m-d\TH:i:s\Z"));
//    $tijd = gmdate("Y-m-d\TH:i:s\Z");
    $tijd->modify(
        '+' . $daysModify . 'days' .
               '+' . $hoursModify . 'hours' .
               '+' . $minutesModify . 'minutes' .
               '+' . $secondsModify . 'seconds' );
    return $tijd->format("Y-m-d H:i:s");

}







