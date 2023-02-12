<?php
session_start();
include "core/init.php";
$ctr  = new Controller();
$ctr->logout();
?>