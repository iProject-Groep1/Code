<?php


function createItemScript($productName, $timeOfEnding, $image, $hoogsteBod, $id, $dbh)
{
    $datetime1 = date_create('getServerTime($dbh)');

    try {
        $stmt = $dbh->prepare("SELECT LooptijdEindMoment FROM Voorwerp v WHERE v.Voorwerpnummer = :Voorwerpnummer"); /* prepared statement */
        $stmt->bindValue(":Voorwerpnummer", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        while ($results = $stmt->fetch()) {
            $datetime2 = date_create($results['LooptijdEindMoment']);
        }
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');
    }
    $date1 = new DateTime($datetime1);
    $date2 = new DateTime($datetime2);

    $echo = $date1->diff($date2)->format("%d days, %h hours %i minuts and %s seconds ");


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
                <div class="uk-align-left uk-display-inline uk-countdown-number"> € ' . $hoogsteBod . '</div>
                <div class=" uk-align-right uk-display-inline-block">
                ';

    if ($echo['d'] < 1) {
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
//    return $itemCard;
    echo $echo;
    echo '<br>';
}


?>
