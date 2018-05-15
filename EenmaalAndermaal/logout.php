<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Page Redirection</title>
</head>

<body>

<?php
session_start();
if (isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['lastVisited'] = $_SERVER['HTTP_REFERER'];
}

session_unset();
echo "Als je niet automatisch doorgestuurd wordt, klik dan op " ?><a href='http://example.com'>deze link</a><?php ; ?>

<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    session_destroy();
}
?>
    <script type="text/javascript">
        window.location.href ='<?php echo($_GET['lastVisited']); ?>'
    </script>
<?php echo($_GET['lastVisited']);
echo $_SERVER['HTTP_REFERER']?>
</body>
</html>
