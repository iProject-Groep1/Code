<?php


function createItemScript($productName, $timeOfEnding, $image, $hoogsteBod, $id, $dbh)
{
    $date1 = getServerTime($dbh);
    $date2 = $timeOfEnding;

    $date1Timestamp = strtotime($date1);
    $date2Timestamp = strtotime($date2);

//Calculate the difference.
    $difference = $date2Timestamp - $date1Timestamp;
    $sec = 1;
    $min = ($sec * 60);
    $hrs = ($sec * 60 * 60);
    $day = ($sec * 60 * 60 * 24);
    $mon = ($sec * 60 * 60 * 24 * 30.4167);
    $yrs = ($sec * 60 * 60 * 24 * 30.4167 * 12);
    $years = 0;
    $months = 0;
    $days = 0;
    $hours = 0;
    $minutes = 0;
    $seconds = 0;
    while ($yrs <= $difference) {
        $years = $years + 1; //how many years are there in difference
        $difference = $difference - $yrs; // difference - years converted to second

    }
    while ($mon <= $difference) {
        $months = $months + 1;//how many months are there in remaining difference
        $difference = $difference - $mon; // difference - months converted to second
    }
    while ($day <= $difference) {
        $days = $days + 1;//how many days are there in remaining difference
        $difference = $difference - $day; // difference - days converted to second
    }
    while ($hrs <= $difference) {
        $hours = $hours + 1;//how many hours are there in remaining difference
        $difference = $difference - $hrs; // difference - hourss converted to second
    }
    while ($min <= $difference) {
        $minutes = $minutes + 1;//how many minutes are there in remaining difference
        $difference = $difference - $min; // difference - minutes converted to second
    }
    while ($sec <= $difference) {
        $seconds = $seconds + 1;//how many seconds are there in remaining difference
        $difference = $difference - $sec; // difference - seconds
    }

    //creeërt een itemCard met plaatje, titel, tijd, prijs en "Bekijk nu" knop.
    $itemCard = '
    <div class="uk-auction-margin">

        <div class=" uk-inline uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
            <div style="width:325px;height:250px">
            <a href="detailpage.php?id=' . $id . '">
                <img class="uk-flex-center uk-align-center" src="' . $image . '"
                     style="background-image: url(images/productImages/' . $image . ');" alt="Image"></a>
            </div>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                        <div class="">
                <h5 class="uk-display-inline-block text-overflow uk-width-3-5">' . $productName . '</h5>
              
                <a class="uk-button uk-button-danger uk-align-right uk-width-2-5" href="detailpage.php?id=' . $id . '">Bekijk nu</a>
                </div>
                <div class="uk-width-1">
                <h4 class="uk-align-left uk-countdown-number"> €' . $hoogsteBod . '</h4>
                <div class="">
                
                <div class=" uk-align-right uk-display-inline-block">
                ';
    //Berekent of de volledige tijd of bijv. 3 dagen/2 uur getoond moet worden.
    if ($days >= 1) {
        $itemCard .= '<div class="uk-countdown-number uk-countdown-days uk-text-center"> ' . $days . ' Dagen  </div>';
    } else if ($days < 1 && $hours >= 1) {
        $itemCard .= '<div class="uk-countdown-number uk-countdown-days uk-text-center"> ' . $hours . ' Uur  </div>';
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
        </div>
    </div>
                            ';
    return $itemCard;

}

function createMyBids($productName, $timeOfEnding, $image, $hoogsteBod, $id, $dbh)
{
    $date1 = getServerTime($dbh);
    $date2 = $timeOfEnding;

    $date1Timestamp = strtotime($date1);
    $date2Timestamp = strtotime($date2);

//Calculate the difference.
    $difference = $date2Timestamp - $date1Timestamp;
    $sec = 1;
    $min = ($sec * 60);
    $hrs = ($sec * 60 * 60);
    $day = ($sec * 60 * 60 * 24);
    $mon = ($sec * 60 * 60 * 24 * 30.4167);
    $yrs = ($sec * 60 * 60 * 24 * 30.4167 * 12);
    $years = 0;
    $months = 0;
    $days = 0;
    $hours = 0;
    $minutes = 0;
    $seconds = 0;
    while ($yrs <= $difference) {
        $years = $years + 1; //how many years are there in difference
        $difference = $difference - $yrs; // difference - years converted to second

    }
    while ($mon <= $difference) {
        $months = $months + 1;//how many months are there in remaining difference
        $difference = $difference - $mon; // difference - months converted to second
    }
    while ($day <= $difference) {
        $days = $days + 1;//how many days are there in remaining difference
        $difference = $difference - $day; // difference - days converted to second
    }
    while ($hrs <= $difference) {
        $hours = $hours + 1;//how many hours are there in remaining difference
        $difference = $difference - $hrs; // difference - hourss converted to second
    }
    while ($min <= $difference) {
        $minutes = $minutes + 1;//how many minutes are there in remaining difference
        $difference = $difference - $min; // difference - minutes converted to second
    }
    while ($sec <= $difference) {
        $seconds = $seconds + 1;//how many seconds are there in remaining difference
        $difference = $difference - $sec; // difference - seconds
    }

    //creeërt een itemCard met plaatje, titel, tijd, prijs en "Bekijk nu" knop. Wanneer een gebruiker overgeboden is wordt de prijs rood.
    $itemCard = '
    <div class="uk-auction-margin">

        <div class=" uk-inline uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
            <div style="width:325px;height:250px">
            <a href="detailpage.php?id=' . $id . '">
                <img class="uk-flex-center uk-align-center" src="' . $image . '"
                     style="background-image: url(images/productImages/' . $image . ');" alt="Image"></a>
            </div>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                    <div class="">
                           <h5 class="uk-display-inline-block text-overflow uk-width-3-5">' . $productName . '</h5>
                           <a class="uk-button uk-button-danger uk-align-right uk-width-2-5" href="detailpage.php?id=' . $id . '">Bekijk nu</a>
                        </div>
                        <div class="uk-width-1">
                         <h4 class="uk-align-left uk-countdown-number" style="
                ';
                if (getHighestBidder($dbh, $id) != $_SESSION['username']){
                    $itemCard.= 'color:#db4c4c;';
                } else {
                    $itemCard.= 'color:#4CBB17;';
                }
                $itemCard.='
                "> €' . $hoogsteBod . '</h4>
                <div class="">
                  <div class=" uk-align-right uk-display-inline-block">
                ';
    //Berekent of de volledige tijd of bijv. 3 dagen/2 uur getoond moet worden.
    if ($days >= 1) {
        $itemCard .= '<div class="uk-countdown-number uk-countdown-days uk-text-center"> ' . $days . ' Dagen  </div>';
    } else if ($days < 1 && $hours >= 1) {
        $itemCard .= '<div class="uk-countdown-number uk-countdown-days uk-text-center"> ' . $hours . ' Uur  </div>';
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
                    </div>'
        ;


               


    }
    $itemCard .= '
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
                            ';
    return $itemCard;

}
