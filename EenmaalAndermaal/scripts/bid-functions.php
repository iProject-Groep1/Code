<?php
//rekent het minimale bod uit.
function calcMinBid($dbh, $id)
{
    $minBod = 0;
    $highestBid = getHighestBid($dbh, $id);
    if(is_null($highestBid)){
        $highestBid = getStartPrice($dbh, $id);
    }
    $minIncrement = 0.01;
    $increment = 0.50;
    $increment1 = 1.00;
    $increment2 = 5.00;
    $increment3 = 10.00;
    $increment4 = 50.00;

    if ($highestBid < 1) {
        $minBod = $highestBid + $minIncrement;
    } else if ($highestBid < 49.99) {
        $minBod = $highestBid + $increment;
    } else if ($highestBid < 499.99) {
        $minBod = $highestBid + $increment1;
    } else if ($highestBid < 999.99) {
        $minBod = $highestBid + $increment2;
    } else if ($highestBid < 4999.99) {
        $minBod = $highestBid + $increment3;
    } else if ($highestBid > 5000) {
        $minBod = $highestBid + $increment4;
    }
    return $minBod;
}

//sla het bod op.
function setOwnBid($dbh, $id, $bod, $voorwerp)
{
    $bodbedrag = $bod;
    $gebruiker = $_SESSION['username'];
    $bodtijd = getServerTime($dbh);

    if ($bodbedrag > insertMinBid($dbh, $id)) {
        try {
            $sql = "INSERT INTO Bod(voorwerp, bodbedrag, gebruiker, bodtijd) VALUES(?,?,?,?)"; /* prepared statement */
            $query = $dbh->prepare($sql);
            $query->execute(array($voorwerp, $bodbedrag, $gebruiker, $bodtijd));
        } catch (PDOException $e) {
            echo "Fout" . $e->getMessage();
            header('Location: ../errorpage.php?err=500');
        }
    } else {
        echo "Het bedrag is te weinig! Vul een groter bedrag in.";
    }

}

//haal het hoogste bod op
function getHighestBid($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT MAX(Bodbedrag) as Hoogstebod FROM Bod b WHERE b.Voorwerp = :Voorwerp"); /* prepared statement */
        $stmt->bindValue(":Voorwerp", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        if ($results = $stmt->fetch()) {
            $row = $results['Hoogstebod'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }

}

//haal de verkoper op.
function getSeller($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT verkoper from voorwerp v WHERE voorwerpnummer = :Voorwerp"); /* prepared statement */
        $stmt->bindValue(":Voorwerp", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        if ($results = $stmt->fetch()) {
            $row = $results['verkoper'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }

}

//haal de bieder op die het hoogste bod geplaatst heeft.
function getHighestBidder($dbh, $id)
{
    try {
        $stmt = $dbh->prepare("SELECT top 1 MAX(Bodbedrag) as Hoogstebod, gebruiker from Bod b WHERE b.Voorwerp = :Voorwerp group by gebruiker order by Hoogstebod desc"); /* prepared statement */
        $stmt->bindValue(":Voorwerp", $id, PDO::PARAM_STR); /* helpt tegen SQL injection */
        $stmt->execute(); /* stuurt alles naar de server */
        if ($results = $stmt->fetch()) {
            $row = $results['gebruiker'];
        }
        return $row;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }

}

//haal de startprijs van een voorwerp op.
function getStartPrice($dbh, $id){
    try{
        $stmt = $dbh->prepare("SELECT startprijs FROM voorwerp where voorwerpnummer = :voorwerpnummer");
        $stmt->bindValue(":voorwerpnummer", $id, PDO::PARAM_STR);
        $stmt->execute();
        if($results = $stmt->fetch()){
            $startPrice = $results['startprijs'];
        }
        return $startPrice;
    } catch (PDOException $e){
        echo "Fout" . $e->getMessage();
        header('Location: ../errorpage.php?err=500');
    }
}

//haal een lijst op met alle biedingen.
function getBids($dbh, $aantal = 5)
{
    $bid = "";
    $objectNumber = $_GET['id'];
    try {
        $stmt = $dbh->prepare("SELECT TOP $aantal bodbedrag, gebruiker FROM dbo.Bod WHERE voorwerp = :voorwerp ORDER BY bodbedrag DESC");
        $stmt->bindValue(":voorwerp", $objectNumber, PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $bid .= '<div class="uk-grid margin-biedingen-detail"><div class="uk-width-1-2">' . $row['bodbedrag'] . '</div><div class="uk-width-1-2">' . $row['gebruiker'] . '</div></div>';
        }
        return $bid;
    } catch (PDOException $e) {
        echo "Fout" . $e->getMessage();
        header('Location: errorpage.php?err=500');

    }
}