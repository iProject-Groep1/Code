<?php


function createItemScript($productName, $timeOfEnding, $image, $hoogsteBod, $id)
{

    $echo = '
    <div class="uk-auction-margin">
    
        <div class=" uk-inline uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
            <div style="width:325px;height:250px">
            <a href="detailpage.php?id=' . $id . '">
                <img class="uk-flex-center uk-align-center" src="images/productImages/' . $image . '"
                     style="background-image: url(images/productImages/' . $image . ');" alt="Image"></a>
            </div>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                <h3 class="uk-text-center uk-display-inline">' . $productName . '</h3>
    
                <button class="uk-button uk-button-danger uk-align-right">Bied nu</button>
                <br>
                <div class="uk-align-left uk-display-inline uk-countdown-number"> € ' . $hoogsteBod . '</div>
                <div class=" uk-align-right uk-display-inline-block">
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
                    </div>
    
                </div>
            </div>
        </div>
    
    </div>

                            ';

    echo $echo;
}


?>
