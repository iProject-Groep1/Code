<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="UIkit/css/uikit.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="UIkit/js/uikit-icons.min.js"></script>
    <script src="UIkit/js/uikit.min.js"></script>
</head>


<body>

<nav class=" responsive-mobile uk-navbar uk-navbar1 uk-margin" uk-navbar="dropbar: true">
    <div class="uk-flex-center">
        <a href="#" class="uk-navbar-item uk-navbar1 uk-logo">
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
            <li>
                <a href="#" class="" aria-expanded="false">Rubrieken</a>
                <div class="uk-navbar-dropdown uk-navbar-dropdown-width-2 uk-navbar-dropdown-bottom-left uk-animation-fade uk-animation-enter"
                     style="left: 416.188px; top: 80px; animation-duration: 200ms;">
                    <div class="uk-navbar-dropdown-grid uk-child-width-1-2 uk-grid" uk-grid="">
                        <div class="uk-first-column">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header">Klassiekers</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            </ul>
                        </div>
                        <div>
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header">Nieuwe types</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            </ul>
                        </div>
                        <div class="uk-grid-margin uk-first-column">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header">Kapotte auto's</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="">Login</a></li>
            <li><a href="">Contact</a></li>
        </ul>
        <div class="uk-navbar-item uk-visible@m uk-navbar1">
            <a href="#" class="uk-button uk-button-default tm-button-default uk-icon">Register now</a>
        </div>
    </div>
</nav>


<nav class=" responsive-laptop uk-navbar uk-navbar2" uk-navbar="">
    <div class="uk-navbar-center">
        <ul class="uk-navbar-nav uk-grid-medium uk-navbar-nav2 uk-visible@m">
            <li><a href="categories.php">Alle Rubrieken</a></li>
            <li><a href="">Huis en tuin</a></li>
            <li>
                <a href="#" class="" aria-expanded="false">Auto's</a>
                <div class="uk-navbar-dropdown uk-navbar-dropdown-width-2 uk-navbar-dropdown-bottom-left"
                     style="left: 310.038px; top: 80px;">
                    <div class="uk-navbar-dropdown-grid uk-child-width-1-2 uk-grid" uk-grid="">
                        <div class="uk-first-column">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header">Klassiekers</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            </ul>
                        </div>
                        <div>
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header">Nieuwe types</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            </ul>
                        </div>
                        <div class="uk-grid-margin uk-first-column">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header">Kapotte auto's</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                                <li class="uk-nav-divider"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="">Elektronica</a></li>
            <li><a href="">Boeken</a></li>
            <li><a href="">Meubels</a></li>
            <li><a href="">Brommers</a></li>
            <li><a href="">Huisdieren</a></li>
            <li><a href="">Vrije tijd</a></li>
        </ul>
    </div>
</nav>
