<head>
    <title></title>
    <link rel="stylesheet" href="UIkit/css/uikit.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="UIkit/js/jquery.js"></script>
    <script src="UIkit/js/uikit.min.js"></script>
</head>



<body>
<h1 class="uk-heading-line uk-text-center">EenmaalAndermaal</h1>

<nav class="uk-navbar">

    <ul class="uk-navbar-nav">
        <li><a href="#offcanvas-1" data-uk-offcanvas=""><i class="uk-icon-justify uk-icon-bars uk-icon-large"></i></a>
        </li>
        <div id="offcanvas-1" class="uk-offcanvas" aria-hidden="true">
            <div class="uk-offcanvas-bar" mode="push">
                <div class="uk-panel">Lorem ipsum dolor sit amet, <a href="#">consectetur</a> adipisicing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </div>

                <div class="uk-panel">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
        <li class="uk-active"><a href="">Home</a></li>
        <li><a href="">Categorien</a></li>
        <li><a href="">Contact</a></li>
        <li><a href="">Plaats advertentie</a></li>
        <li><a href="">Login</a></li>


        <li class="uk-parent" data-uk-dropdown="" aria-haspopup="true" aria-expanded="false">
            <a href="">Parent</a>

            <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" aria-hidden="true"
                 style="top: 40px; left: 0px;" tabindex="">
                <ul class="uk-nav uk-nav-navbar">
                    <li><a href="#">Item</a></li>
                    <li><a href="#">Another item</a></li>
                    <li class="uk-nav-header">Header</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">Another item</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#">Separated item</a></li>
                </ul>
            </div>

        </li>
    </ul>

</nav>

<div class="uk-block uk-block-muted">

    <div class="uk-container">

        <h3>Block</h3>

        <div class="uk-grid uk-grid-match" data-uk-grid-margin="">
            <div class="uk-width-medium-1-3 uk-row-first">
                <div class="uk-panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna.</p>
                </div>
            </div>
            <div class="uk-width-medium-1-3">
                <div class="uk-panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna.</p>
                </div>
            </div>
            <div class="uk-width-medium-1-3">
                <div class="uk-panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna.</p>
                </div>
            </div>
        </div>

    </div>

</div>


</body>

