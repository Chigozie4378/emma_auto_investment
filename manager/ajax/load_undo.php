<?php
include "../core/init.php";
$return_qty = $_POST["returnQty"];
$quantity = $_POST["quantity"];
$productname = $_POST["productname"];
$model = $_POST["model"];
$manufacturer = $_POST["manufacturer"];
$price = $_POST["price"];
$amount = $_POST["amount"];
$invoice_no = $_POST["invoice_no"];
$date = date("d-m-Y");
//

$customer_name = $_POST["customer_name"];
$address = $_POST["address"];
$staff_name = $_POST["staff"];
$comment = "Undo Returned Good(s)";
$debit_total = 0;
//
$rem_qty = $quantity - $return_qty;
$new_amount = $price * $rem_qty;
$return_amount = $price * $return_qty;
$mod = new Model();
$select_sales = $mod->showInvoiceSales1($invoice_no, $customer_name, $address);
if (mysqli_num_rows($select_sales) > 0) {
	
	$mod->updateSalesDetailsUndo($return_qty, $return_amount, $productname, $model, $manufacturer, $invoice_no);
	$mod->updateSalesUndo($return_amount, $invoice_no);
	$mod->updateStockUndoEachQty($return_qty, $productname, $model, $manufacturer);
} else {
	$mod->addSalesDetails($customer_name, $address, $invoice_no, "", $productname, $model, $manufacturer, $return_qty, $price, $return_amount, $staff_name, $date);
}


$show_debits = $mod->showDebitTotalPaidTotalBal($customer_name, $address);
$row = mysqli_fetch_array($show_debits);
$dbtotal_deposit = $row["deposit"];
$dbtotal_bal = $row["balance"];
$total_deposit = $dbtotal_deposit - $return_amount;
$total_bal1 = $dbtotal_bal + $return_amount;
$total_bal2 = $dbtotal_bal + $return_amount;
if (mysqli_num_rows($show_debits) > 0) {
	$mod->updateDebits($total_deposit, $total_bal1, $customer_name, $address);
	$mod->insertDebitsDetailsReturn($customer_name, $address, $debit_total, $return_amount, $total_deposit, $total_bal1, $total_bal2, $staff_name, $date, $comment);
	$mod->deleteDebit();
	$mod->updateEachUndo($invoice_no, $return_amount, $staff_name, $date);
	$mod->updateEachUndoDetails($invoice_no, $productname, $model, $manufacturer, $return_qty, $return_amount, $staff_name, $date);
	$mod->deleteReturnDetailsUndo($invoice_no);
	$mod->deleteReturnUndoEach($invoice_no);

	// header("location:sales_history_details.php?invoice= $invoice_no");
	echo "<script>
	location.reload();
	</script>";
} else {
	$mod->updateEachUndo($invoice_no, $return_amount, $staff_name, $date);
	$mod->updateEachUndoDetails($invoice_no, $productname, $model, $manufacturer, $return_qty, $return_amount, $staff_name, $date);
	$mod->deleteReturnDetailsUndo($invoice_no);
	$mod->deleteReturnUndoEach($invoice_no);
	// header("location:sales_history_details.php?invoice= $invoice_no");
	echo "<script>
	location.reload();
	</script>";
}

?>
