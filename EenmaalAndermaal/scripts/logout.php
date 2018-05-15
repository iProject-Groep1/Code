<?php
$lastVisited = $_SERVER['HTTP_REFERER'];
session_start();
session_unset();
session_destroy();
//TODO: redirecten naar de pagina waar je vandaan kwam, of ie doorgestuurd moet worden naar inlogpagina wordt door het inlogsysteem geregeld
header('Location: ' .$lastVisited);