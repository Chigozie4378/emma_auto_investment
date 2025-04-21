<?php
include "../../../autoload/loader.php";

$shared = new Shared();
$return_goods_ctr = new ReturnGoodsController();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $return_goods_ctr->returnAGood($_POST);
}
