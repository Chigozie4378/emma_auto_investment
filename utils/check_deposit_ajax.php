<?php
include "../autoload/loader.php";
$ctr = new DepositController();
$customer_name = $_GET['customer_name'] ?? '';
$customer_address = $_GET['customer_address'] ?? '';

if (!empty($customer_name) && !empty($customer_address)) {

   $deposit = $ctr->checkDeposit($customer_name, $customer_address);

    if ($deposit) {
        echo json_encode(['success' => true, 'deposit_amount' => $deposit['deposit_amount']]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
