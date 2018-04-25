<?php
function createItem($productName, $timeOfEnding)
{
    $echo = '
    <div class="uk-flex-center uk-card uk-card-default uk-display-inline-block">
    <div class="uk-card-header" >
        <div class="uk-grid-small uk-flex-middle" uk - grid >
            <div class="align-center">
                <h3>' . $productName . '</h3>
            </div >
        </div >
    </div >
    <div class="uk-card-body" >
    <img src="images/ipad.jpg" class="uk-align-center" width="250" height="175">
    </div >
    <div class="uk-card-footer" >
    <p class="uk-text-meta uk-margin-remove-top" >
                <div class="uk-grid-small uk-child-width-auto" uk-grid uk-countdown="date: '. $timeOfEnding . ' ">
    <div>
        <div class="uk-countdown-number uk-countdown-days"></div>
        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Days</div>
    </div>
    <div class="uk-countdown-separator">:</div>
    <div>
        <div class="uk-countdown-number uk-countdown-hours"></div>
        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Hours</div>
    </div>
    <div class="uk-countdown-separator">:</div>
    <div>
        <div class="uk-countdown-number uk-countdown-minutes"></div>
        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Minutes</div>
    </div>
    <div class="uk-countdown-separator">:</div>
    <div>
        <div class="uk-countdown-number uk-countdown-seconds"></div>
        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Seconds</div>
    </div>
</div>
                
</p >
        <a href = "#" class="uk-button tm-button-default uk-button-default2 uk-icon" > BIED NU MEE </a >
</div>
</div>';


    echo $echo;
}


?>


