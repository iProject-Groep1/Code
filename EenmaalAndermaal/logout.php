<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Page Redirection</title>
</head>

<body>

<?php

session_start();
echo "Als je niet automatisch doorgestuurd wordt, klik dan op " ?><a href='index.php'>deze link</a><?php ;

if(isset($_SESSION['username'])){
    session_unset();
    if(isset($_SERVER['HTTP_REFERER'])) {
        $_SESSION['lastVisited'] = $_SERVER['HTTP_REFERER'];
    }

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
