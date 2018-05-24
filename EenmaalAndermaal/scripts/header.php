<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('database-connect.php');

$header = '

<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title>' . $pageTitle . '</title>
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="UIkit/css/uikit.min.css">
    <link rel="stylesheet" href="UIkit/css/awesomplete.css">
    <link rel="stylesheet" href="style.css">
    <script src="UIkit/js/uikit.min.js"></script>
    <script src="UIkit/js/uikit-icons.js"></script>
    <script src="UIkit/js/awesomplete.js"></script>
    <script src="Uikit/js/index.js"></script>
    
</head>


<body>

<nav class=" responsive-mobile uk-navbar uk-navbar1 uk-margin" uk-navbar="dropbar: true">
    <div class="uk-flex-center">
        <a href="index.php" class="uk-navbar-item uk-navbar1 uk-logo">
            <img src="images/auction.png" class="uk-margin-small-right" width="32" height="28">EenmaalAndermaal</a>
    </div>
    <div>
        <ul class="uk-navbar-nav">
            <li>
                <a class="uk-navbar-toggle" uk-navbar-toggle-icon href="#"></a>
                <div class="uk-navbar-dropdown uk-nav-changes">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li class="uk-nav-header">Menu</li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="category-overview.php">Rubrieken</a></li>';
//check of ingelogd is
if (isset($_SESSION['username'])) {
    $header .= '<li><a href="logout.php">Uitloggen</a></li>';
} else {
    $header .= '<li><a href="login.php">Inloggen</a></li>';
}
$header .= '

                        <li><a href="#">Contact</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#">Algemene Voorwaarden</a></li>
                        <li><a href="#">Over EenmaalAndermaal</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>


<nav class=" responsive-laptop uk-navbar uk-navbar1" uk-navbar="">
    <div class="uk-navbar-left">
        <a href="index.php" class="uk-navbar-item uk-navbar1 uk-logo">
            <img src="images/auction.png" class="uk-margin-small-right" width="32" height="28">EenmaalAndermaal</a>
    </div>
    <div class="uk-navbar-right uk-navbar-blue">
        <ul class="uk-navbar-nav uk-navbar-nav1 uk-visible@m">
            <li><a href="index.php">Home</a></li>
            <li><a href="category-overview.php">Rubrieken</a></li>';

//check of ingelogd is
if (isset($_SESSION['username'])) {
    $header .= '<li><a href="logout.php">Uitloggen</a></li>';
} else {
    $header .= '<li><a href="login.php">Inloggen</a></li>';
}
$header .= '
            <li><a href="">Contact</a></li>
        </ul>';
    if(!isset($_SESSION['username'])) {
        $header.='
        <div class="uk-navbar-item uk-visible@m uk-navbar1" >
            <a href = "registration.php" class="uk-button uk-button-danger tm-button-default uk-icon" > Registreer nu </a >
        </div >';
        }
        $header.='
    </div>
</nav>

<nav class=" responsive-laptop uk-navbar uk-navbar2" uk-navbar="">
    <div class="uk-navbar-center">
        <ul class="uk-navbar-nav uk-grid-medium uk-navbar-nav2 uk-visible@m">
            <li><a href="category-overview.php">Alle Rubrieken</a></li>';

            try{
                $stmt = $dbh->prepare("SELECT TOP 9 COUNT(voorwerpnummer) AS aantal, r.rubrieknaam, r.rubrieknummer FROM Voorwerp v JOIN VoorwerpInRubriek vir ON v.voorwerpnummer = vir.voorwerp JOIN rubriek r ON  vir.rubriek_op_laagste_Niveau = r.rubrieknummer WHERE veilinggesloten = 0 GROUP BY r.rubrieknaam, r.rubrieknummer ORDER BY aantal desc
");
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $header.='<li><a href="category.php?categoryID='.$row['rubrieknummer'].'">'.$row['rubrieknaam'].'</a></li>';
                }
            } catch(PDOException $e){
                echo "Error" . $e->getMessage();
                header('Location: errorpage.php?err=500');
            }
            
            $header.='
        </ul>
    </div>
</nav>
';

echo $header;
?>
