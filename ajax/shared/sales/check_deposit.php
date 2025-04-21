<?php
include "../../../autoload/loader.php";

$ctr = new DepositController();
$title = $_POST["title"];
$name = $_POST["name"];
$customer_name = $title . " " . $name;
$customer_address = $_POST["customer_address"];
$deposit  = $ctr->checkDeposit($customer_name, $customer_address);

header('Content-Type: application/json');

if ($deposit) {
    echo json_encode([
        'success' => true,
        'amount' => $deposit['deposit_amount']
    ]);
} else {
    echo json_encode([
        'success' => false
    ]);
}