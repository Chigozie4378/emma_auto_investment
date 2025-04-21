<?php
$total = $_GET["total"];
$deposit = $_GET["deposit"];
echo $balance = (int)($total) - (int)($deposit);

?>