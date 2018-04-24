<?php

function createItem()
{
    $echo = '
    <div class="uk-card uk-card-default " >
    <div class="uk-card-header" >
        <div class="uk-grid-small uk-flex-middle" uk - grid >
            <div class="uk-width-expand" >
                <h3 class="uk-card-title uk-margin-remove-bottom" > Title</h3 >
                <p class="uk-text-meta uk-margin-remove-top" >
                <div class="uk-grid-small uk-child-width-auto" uk-grid uk-countdown="date: 2018-05-01T13:04:01+00:00">
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
            </div >
        </div >
    </div >
    <div class="uk-card-body" >
        <p > Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt .</p >
    </div >
    <div class="uk-card-footer" >
        <a href = "#" class="uk-button uk-button-text" > BIED NU MEE </a >
    </div >
</div >';

    echo $echo;
}


?>


