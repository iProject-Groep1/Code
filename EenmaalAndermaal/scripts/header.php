<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="UIkit/css/uikit.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="UIkit/js/uikit-icons.js"></script>
    <script src="UIkit/js/uikit.min.js"></script>
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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Rubrieken</a></li>
                        <li><a href="#">Login</a></li>
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
        <a href="#" class="uk-navbar-item uk-navbar1 uk-logo">
            <img src="images/auction.png" class="uk-margin-small-right" width="32" height="28">EenmaalAndermaal</a>
    </div>
    <div class="uk-navbar-right uk-navbar-blue">
        <ul class="uk-navbar-nav uk-navbar-nav1 uk-visible@m">
            <li><a href="">Home</a></li>
            <li><a href="categoryOverview.php">Rubrieken</a></li>
            <li><a href="">Login</a></li>
            <li><a href="">Contact</a></li>
        </ul>
        <div class="uk-navbar-item uk-visible@m uk-navbar1">
            <a href="#" class="uk-button uk-button-danger tm-button-default uk-icon">Register now</a>
        </div>
    </div>
</nav>


<nav class=" responsive-laptop uk-navbar uk-navbar2" uk-navbar="">
    <div class="uk-navbar-center">
        <ul class="uk-navbar-nav uk-grid-medium uk-navbar-nav2 uk-visible@m">
            <li><a href="categoryOverview.php">Alle Rubrieken</a></li>
            <li><a href="category.php?categoryID=1">Verzamelen</a></li>
            <li><a href="category.php?categoryID=9800">Auto's, motoren en boten</a></li>
            <li><a href="category.php?categoryID=160">Computers</a></li>
            <li><a href="category.php?categoryID=11700">Huis en tuin</a></li>
            <li><a href="category.php?categoryID=12081">Baby</a></li>
            <li><a href="category.php?categoryID=293">Consumentenelektronica</a></li>
            <li><a href="category.php?categoryID=12155">Gezondheid en verzorging</a></li>
            <li><a href="category.php?categoryID=353">Kunst, antiek en design</a></li>
        </ul>
    </div>
</nav>
