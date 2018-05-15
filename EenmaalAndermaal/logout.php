<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Page Redirection</title>
</head>

<body>

<?php

session_start();
<<<<<<< HEAD
$lastVisited = "index.php";
if (isset($_SERVER['HTTP_REFERER'])) {
    $lastVisited = $_SERVER['HTTP_REFERER'];
}

session_unset();
echo "Als je niet automatisch doorgestuurd wordt, klik dan op " ?><a href="'.$lastVisited.'">deze link</a><?php ; ?>
=======
echo "Als je niet automatisch doorgestuurd wordt, klik dan op " ?><a href='index.php'>deze link</a><?php ;

if(isset($_SESSION['username'])){
    session_unset();
    if(isset($_SERVER['HTTP_REFERER'])) {
        $_SESSION['lastVisited'] = $_SERVER['HTTP_REFERER'];
    }
>>>>>>> 8bcc0396d7a81f5ddfbd642d1572ae13fec6a97e

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        session_destroy();
    }
}
else{
    header('Location: index.php');
}

?>
</body>
</html>
