<?php
include "../../../autoload/loader.php";

$controller = new SalesController();
$shared = new Shared();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->updatePayment($_POST);
    // echo "<script>location.reload();</script>";
}
