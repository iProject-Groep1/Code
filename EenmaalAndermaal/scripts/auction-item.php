<?php


function createItemScript($productName, $timeOfEnding, $image, $hoogsteBod, $id, $dbh)
{
    $date1 = getServerTime($dbh);
    $date2 = $timeOfEnding;

    $date1Timestamp = strtotime($date1);
    $date2Timestamp = strtotime($date2);

//Calculate the difference.
    $difference = $date2Timestamp - $date1Timestamp;
    $sec=1;
    $min=($sec * 60);
    $hrs=($sec * 60 * 60);
    $day=($sec * 60 * 60 * 24);
    $mon=($sec * 60 * 60 * 24 * 30.4167);
    $yrs=($sec * 60 * 60 * 24 * 30.4167 * 12);
    $years=0;$months=0;$days=0;$hours=0;$minutes=0;$seconds=0;
    while ($yrs <= $difference){
        $years= $years + 1; //how many years are there in difference
        $difference= $difference - $yrs; // difference - years converted to second

    }
    while ($mon <= $difference){
        $months= $months + 1;//how many months are there in remaining difference
        $difference= $difference- $mon; // difference - months converted to second
    }
    while ($day <= $difference){
        $days= $days + 1;//how many days are there in remaining difference
        $difference= $difference- $day; // difference - days converted to second
    }
    while ($hrs <= $difference){
        $hours= $hours + 1;//how many hours are there in remaining difference
        $difference= $difference- $hrs; // difference - hourss converted to second
    }
    while ($min <= $difference){
        $minutes= $minutes + 1;//how many minutes are there in remaining difference
        $difference= $difference- $min; // difference - minutes converted to second
    }
    while ($sec <= $difference){
        $seconds= $seconds + 1;//how many seconds are there in remaining difference
        $difference= $difference- $sec; // difference - seconds
    }

    $itemCard = '
    <div class="uk-auction-margin">

        <div class=" uk-inline uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
            <div style="width:325px;height:250px">
            <a href="detailpage.php?id=' . $id . '">
                <img class="uk-flex-center uk-align-center" src="images/productImages/' . $image . '"
                     style="background-image: url(images/productImages/' . $image . ');" alt="Image"></a>
            </div>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                <h3 class="uk-text-center uk-display-inline">' . $productName . '</h3>
    <!--TODO: Hier een bied minimum knop van maken??? -->
                <a class="uk-button uk-button-danger uk-align-right" href="detailpage.php?id=' . $id . '">Bekijk nu</a>
                <br>
                <div class="uk-align-left uk-vertical-align-bottom uk-display-inline uk-countdown-number"> € ' . $hoogsteBod . '</div>
                <div class=" uk-align-right uk-display-inline-block">
                ';
    if($days >= 1){
        $itemCard .= '<div class="uk-countdown-number uk-countdown-days uk-text-center"> '. $days . ' Dagen  </div>';
    } else if ($days < 1 && $hours >= 1) {
        $itemCard .= '<div class="uk-countdown-number uk-countdown-days uk-text-center"> '. $hours . ' Uur  </div>';
    } else if ($hours < 1) {
        $itemCard .= '
                    <div class="uk-grid-small uk-child-width-auto" uk-grid uk-countdown="date: ' . $timeOfEnding . ' ">
                        <div>
                            <div class="uk-countdown-number uk-countdown-days uk-text-center"></div>
                        </div>
                        <div class="uk-countdown-separator">:</div>
                        <div>
                            <div class="uk-countdown-number uk-countdown-hours uk-text-center"></div>
                        </div>
                        <div class="uk-countdown-separator">:</div>
                        <div>
                            <div class="uk-countdown-number uk-countdown-minutes uk-text-center"></div>
                        </div>
                        <div class="uk-countdown-separator">:</div>
                        <div>
                            <div class="uk-countdown-number uk-countdown-seconds uk-text-center"></div>
                        </div>
                    </div>';
    }


    $itemCard .= '
                </div>
            </div>
        </div>
    </div>
                            ';
    return $itemCard;

}


?>
