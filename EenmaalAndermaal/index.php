<?php
require_once('scripts/header.php');
include('scripts/AuctionItem.php');
include('scripts/HomepageFunctions.php');
include('scripts/database-connect.php')
?>


<body>

<div class="uk-grid  uk-flex uk-flex-center auctions-reset-margin">

    <?php
    $AllItems = checkNumbers($dbh);
    print_r($AllItems);

    function checkNumbers($dbh)
    {
        $results = "";
        try {
            $stmt = $dbh->query("SELECT Voorwerpnummer FROM Voorwerp v WHERE v.Voorwerpnummer IS NOT NULL"); /* prepared statement */

            while ($row = $stmt->fetch()) {
                createItem($dbh, $row['Voorwerpnummer']);
                echo "<br>";

            }

            return $results;

        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
        }
    }


    //    foreach($AllItems as $item) {
    //        echo $item;
    //        createItem($dbh, $item);
    //        echo "<br>";
    //    }

    ?>

</div>


<?php
require_once('scripts/footer.php');
?>

</body>

