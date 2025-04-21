<?php
session_start();
$delete = $_GET["id"];
$b = array("productname"=>"","model"=>"","manufacturer"=>"","quantity"=>"","price"=>"");
$_SESSION["cart"][$delete]=$b; 
?>