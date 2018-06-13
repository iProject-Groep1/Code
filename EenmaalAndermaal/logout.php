<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Page Redirection</title>
</head>

<body>

<?php

session_start();

$lastVisited = "index.php";
if (isset($_SERVER['HTTP_REFERER'])) {
    $lastVisited = $_SERVER['HTTP_REFERER'];
}

session_unset();
session_destroy();
echo 'Als je niet automatisch doorgestuurd wordt, klik dan op <a href="' . $lastVisited . '">deze link</a>';
header('Location: ' . $lastVisited);

?>
</body>
</html>
