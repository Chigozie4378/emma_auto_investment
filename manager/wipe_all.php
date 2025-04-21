<?php
include "core/init.php";
session_start();
Session::directorAccess("directorusername");
$ctr = new Controller();
$ctr->wipeTables();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
    <input type="submit" name="wipe" value="Drop Tables">
    </form>
</body>
</html>