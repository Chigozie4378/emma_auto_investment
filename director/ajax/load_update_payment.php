<?php
include "../core/init.php";
$mod = new Model();
$invoice_no = $_POST["invoice_no"];
$deposit = (int)$_POST["deposit"];
$bank_name = $_POST["bank"];
$customer_name = $_POST["customer_name"];
$address = $_POST["address"];
$date = $_POST["date"];
$staff = $_POST["staff"];		
$customer_type = $_POST["customer_type"];	
$new_transfer = (int)$_POST["new_transfer"];
$new_cash = (int)$_POST["new_cash"];
$new_pos = (int)$_POST["new_pos"];
$total = (int)$_POST["total"];

$comment = "New Goods Bought";
$status = "pending";

$total_paid = $new_transfer + $new_cash + $new_pos;

$new_balance = $total - $total_paid;
$new_payment = $total_paid-$deposit;


if ($new_cash == 0 && $new_transfer == 0 && $new_pos == 0 && $new_balance != 0) {
	$payment_type = "Debit";

} elseif ($new_cash == 0 && $new_transfer != 0 && $new_pos == 0 && $new_balance == 0) {
	$payment_type = "Transfer";

} elseif ($new_cash != 0 && $new_transfer == 0 && $new_pos == 0 && $new_balance == 0) {
	$payment_type = "Cash";

} elseif ($new_cash == 0 && $new_transfer == 0 && $new_pos != 0 && $new_balance == 0) {
	$payment_type = "POS";

} elseif ($new_cash != 0 && $new_transfer != 0 && $new_pos == 0 && $new_balance == 0) {
	$payment_type = "Cash/Transfer";

} elseif ($new_cash != 0 && $new_transfer == 0 && $new_pos != 0 && $new_balance == 0) {
	$payment_type = "Cash/POS";

} elseif ($new_cash != 0 && $new_transfer == 0 && $new_pos == 0 && $new_balance != 0) {
	$payment_type = "Cash/Debit";

} elseif ($new_cash != 0 && $new_transfer != 0 && $new_pos != 0 && $new_balance == 0) {
	$payment_type = "Cash/Transfer/POS";

} elseif ($new_cash != 0 && $new_transfer == 0 && $new_pos != 0 && $new_balance != 0) {
	$payment_type = "Cash/POS/Debit";
	
} elseif ($new_cash != 0 && $new_transfer != 0 && $new_pos == 0 && $new_balance != 0) {
	$payment_type = "Cash/Transfer/Debit";
	
} elseif ($new_cash != 0 && $new_transfer != 0 && $new_pos != 0 && $new_balance != 0) {
	$payment_type = "Cash/Transfer/POS/Debit";
	
} elseif ($new_cash == 0 && $new_transfer != 0 && $new_pos != 0 && $new_balance == 0) {
	$payment_type = "Transfer/POS";
	
} elseif ($new_cash == 0 && $new_transfer != 0 && $new_pos == 0 && $new_balance != 0) {
	$payment_type = "Transfer/Debit";
	
} elseif ($new_cash == 0 && $new_transfer != 0 && $new_pos != 0 && $new_balance != 0) {
	$payment_type = "Transfer/POS/Debit";
	
} elseif ($new_cash == 0 && $new_transfer == 0 && $new_pos != 0 && $new_balance != 0) {
	$payment_type = "POS/Debit";
	
}



$new_payment;
if (mysqli_num_rows($mod->checkBankExist($invoice_no)) > 0){
	if ($new_transfer == 0){
		$mod->deleteTransfer($invoice_no);
	}else{
		$mod->updateBank($new_transfer, $bank_name, $staff, $date, $invoice_no);
	}
	

}else{
	if ($new_transfer == 0){
		$mod->deleteTransfer($invoice_no);
	}else{
		$mod->addBank($customer_name, $address, $invoice_no, $customer_type, $new_transfer, $bank_name, $status, $staff, $date);
	}
	
}


$row = mysqli_num_rows($mod->checkDebitInvoice($invoice_no));
$row2 = mysqli_num_rows($mod->checkDebit($customer_name, $address));

$history = mysqli_fetch_array($mod->checkDebitInvoice($invoice_no));
$depositdb = $history["deposit"];
$prev_total_paid = $history["total_paid"];
$balancedb = $history["balance"];
$total_balancedb = $history["total_balance"];

$updated_deposit = $depositdb+$new_payment;
$updated_total_deposit = $prev_total_paid+$new_payment;
$updated_balance = $balancedb-$new_payment;
$updated_total_balance = $total_balancedb-$new_payment;


if ($row > 0) {
		$mod->updateDebitPayment($new_payment,$customer_name, $address);
		$mod->updateDebitHistoriesPayment($updated_deposit, $updated_total_deposit, $updated_balance,$updated_total_balance,$invoice_no);
		$mod->deleteDebit();
} else {
		if ($new_balance != 0) {
			if ($row2 > 0){
				$mod->updateDebitPayment($new_payment,$customer_name, $address);
				$mod->addDebitHistoriesPayment($customer_name, $address,$total, $total_paid, $new_balance, $staff, $date, $comment,$invoice_no);
				$mod->deleteDebit();
			}else{
				$mod->addDebitsPayment($customer_name, $address, $total, $total_paid, $new_balance, $staff, $date);
				$mod->deleteDebit();
				$mod->addDebitHistoriesPayment($customer_name, $address,$total, $total_paid, $new_balance, $staff, $date, $comment,$invoice_no);
			}
		}
}


$mod->updatePaymentSales($new_transfer,$new_cash,$new_pos,$total_paid,$new_balance,$payment_type,$invoice_no);
echo "<script>
	location.reload();
	</script>";












