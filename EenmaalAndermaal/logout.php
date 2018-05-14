
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Page Redirection</title>
</head>

<body>
<?php
echo "If you are not redirected automatically, follow this <a href='http://example.com'>link to example</a>."
?>
<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
session_destroy();
}
?>
<script type="text/javascript">
    window.location.href = "index.php"
</script>

</body>
</html>
