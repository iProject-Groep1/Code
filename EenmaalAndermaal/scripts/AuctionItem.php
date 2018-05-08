<?php


function createItemScript($productName, $timeOfEnding, $image, $hoogstebod, $dbh)
{

    $echo = '
    <div class="uk-auction-margin">

        <div class="uk-inline uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
            <img src="images/productImages/' . $image . '" style="width:325px;height:250px;" alt="Image">
            <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                <h3 class="uk-text-center uk-display-inline">' . $productName . '</h3>
                
                <button class="uk-button uk-button-danger uk-align-right">Bied nu</button>
                <br>
                <div class="uk-align-left uk-display-inline uk-countdown-number"> € ' . $hoogstebod . '</div>
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


<!--//    $echo = '-->
<!--//    <div class="uk-flex-center uk-card uk-card-default uk-display-inline-block uk-grid-changes">-->
<!--//    <div class="uk-card-header" >-->
<!--//        <div class="uk-grid-small uk-flex-middle" uk - grid >-->
<!--//            <div class="align-center">-->
<!--//                <h3>' . $productName . '</h3>-->
<!--//            </div >-->
<!--//        </div >-->
<!--//    </div >-->
<!--//    <div class="uk-card-body uk-inline-clip uk-transition-toggle" tabindex="0" >-->
<!--//        <img src="images/productImages/'. $image .'" class="uk-align-center uk-transition-scale-up uk-transition-opaque" width="250" height="175">-->
<!--//    </div >-->
<!--//    <div class="uk-card-footer" >-->
<!--    <p class="uk-text-meta uk-margin-remove-top" >-->
<!--                <div class="uk-grid-small uk-child-width-auto" uk-grid uk-countdown="date: ' . $timeOfEnding . ' ">-->
<!--    <div>-->
<!--        <div class="uk-countdown-number uk-countdown-days uk-text-center"></div>-->
<!--        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s uk-font-size-changes">Days</div>-->
<!--    </div>-->
<!--    <div class="uk-countdown-separator">:</div>-->
<!--    <div>-->
<!--        <div class="uk-countdown-number uk-countdown-hours uk-text-center"></div>-->
<!--        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s uk-font-size-changes">Hours</div>-->
<!--    </div>-->
<!--    <div class="uk-countdown-separator">:</div>-->
<!--    <div>-->
<!--        <div class="uk-countdown-number uk-countdown-minutes uk-text-center"></div>-->
<!--        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s uk-font-size-changes">Minutes</div>-->
<!--    </div>-->
<!--    <div class="uk-countdown-separator">:</div>-->
<!--    <div>-->
<!--        <div class="uk-countdown-number uk-countdown-seconds uk-text-center"></div>-->
<!--        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s uk-font-size-changes">Seconds</div>-->
<!--    </div>-->
<!--</div>-->
<!--                -->
<!--</p >-->
<!--//        <a href = "#" class="uk-button tm-button-default uk-button-default2 uk-icon" > BIED NU MEE </a >-->
<!--//</div>-->
<!--//</div>';-->