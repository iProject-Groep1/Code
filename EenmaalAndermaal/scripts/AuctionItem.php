<?php



function createItemScript($productName, $timeOfEnding, $image, $hoogsteBod)
{

    $echo = '
    <div class="uk-auction-margin">

        <div class="uk-inline uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
            <img src="images/productImages/' . $image . '" style="width:325px;height:250px;background-size: cover;    background-repeat: no-repeat;  background-position: 50% 50%; " alt="Image">
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
