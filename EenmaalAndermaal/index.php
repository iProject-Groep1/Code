<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
include('scripts/database-connect.php')
?>


<body>

<div class="uk-grid uk-align-center uk-width-medium-1-4 uk-flex uk-flex-center auctions-reset-margin">

    <?php
    $AllItems = checkNumbers($dbh);
    print_r($AllItems);
<<<<<<< HEAD

    function checkNumbers($dbh)
    {
        $results = "";
        echo '
                <div class="uk-child-width-1-4@m uk-grid" uk-grid>';

        try {
            $stmt = $dbh->query("SELECT Voorwerpnummer FROM Voorwerp v WHERE v.Voorwerpnummer IS NOT NULL"); /* prepared statement */

            while ($row = $stmt->fetch()) {
                createItem($dbh, $row['Voorwerpnummer']);
                echo "<br>";

            }
            echo '</div>';
            return $results;

        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }
    }

=======
>>>>>>> f3ae3d85f5f4316730a4106cc04f37df85e1b70e
    ?>

</div>


<?php
require_once('scripts/footer.php');
?>

</body>

