<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="UIkit/css/uikit.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="UIkit/js/jquery.js"></script>
    <script src="UIkit/js/uikit.min.js"></script>
</head>



<body>

<nav class="uk-navbar ">

    <a class="uk-navbar-brand uk-hidden-small" href="">EenmaalAndermaal</a>

    <ul class="uk-navbar-nav uk-hidden-small uk-grid-divider ">

        <li class="uk-parent" data-uk-dropdown="">
            <a href="">Home</a>
        </li>

        <li class="uk-parent" data-uk-dropdown="">
            <a href="">Rubrieken</a>

            <div class="uk-dropdown uk-dropdown-navbar">
                <ul class="uk-nav uk-nav-navbar">
                    <li class="uk-nav-header">Alle rubrieken</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">Item</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#">Separated item</a></li>
                    <li class="uk-parent">
                        <a href="#">Parent</a>
                        <ul class="uk-nav-sub">
                            <li><a href="#">Sub item</a>
                                <ul>
                                    <li><a href="#">Sub item</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>



        </li>

        <li class="uk-parent" data-uk-dropdown="" aria-haspopup="true" aria-expanded="false">
            <a href="">Login</a>
        </li>

        <li class="uk-parent" data-uk-dropdown="" aria-haspopup="true" aria-expanded="false">
            <a href="">Contact</a>
            <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" aria-hidden="true" tabindex="" style="top: 40px; left: 0px;">
                <div class="uk-panel">Lorem ipsum dolor sit amet, consectetur <a href="#">adipisicing</a> elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
            </div>
        </li>

    </ul>

    <a href="#" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas="{target:'#offcanvas-1'}"></a>

</nav>

<nav class="uk-navbar uk-navbar2">

    <ul class="uk-navbar-nav uk-navbar-nav2 uk-hidden-small ">

        <li>
            <a href="">Alle Rubrieken</a>

        <li>
            <a href="">Huis en tuin</a>
        </li>

        <li class="uk-parent" data-uk-dropdown="">
            <a href="">Auto's</a>

            <div class="uk-dropdown uk-dropdown-navbar">
                <ul class="uk-nav uk-nav-navbar">
                    <li class="uk-nav-header">Klassiekers</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">Item</a></li>
                    <li class="uk-nav-header">Nieuwe modellen</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">Item</a></li>
                    <li class="uk-nav-header">Kapotte auto's</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">Item</a></li>
                </ul>
            </div>



        </li>

        <li>
            <a href="">Elektronica</a>
        </li>

        <li>
            <a href="">Boeken</a>
        </li>

        <li>
            <a href="">Meubels</a>
        </li>

        <li>
            <a href="">Brommers</a>
        </li>

        <li>
            <a href="">Huisdieren</a>
        </li>

        <li>
            <a href="">Vrije tijd</a>
        </li>

    </ul>

    <a href="#" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas="{target:'#offcanvas-1'}"></a>

</nav>