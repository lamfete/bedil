<html>
<head>

<title>Administration</title>

<style>
body
{
font-family:Calibri;
}
</style>
</head>
<body>
<?php
    if($userlevel->user_level_id == 1) {
        echo "<h2>Hi, Welcome Administrator</h2>";
    } elseif($userlevel->user_level_id == 2) {
        echo "<h2>Hi, Welcome Owner</h2>";
    }
?>

<a href="<?php echo "/login/logout"; ?>">Logout</a>
</body>
</html>
