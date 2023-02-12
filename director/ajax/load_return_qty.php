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
//

$customer_name = $_POST["customer_name"];
$address = $_POST["address"];
$payment_type = $_POST["payment_type"];
$cash = $_POST["cash"];
$transfer = $_POST["transfer"];
$deposit = $_POST["deposit"];
$balance = $_POST["balance"];
$date = $_POST["date"];
$staff_name = $_POST["staff"];
$comment = "Returned Good(s)";
$debit_total = 0;
//
$rem_qty = $quantity - $return_qty;
$new_amount = $price*$rem_qty;
$return_amount = $price*$return_qty;
$mod = new Model();
$mod->updateSalesDetails($rem_qty,$new_amount,$productname,$model,$manufacturer,$invoice_no);

$mod->updateStockAfterEachReturn($return_qty,$productname,$model,$manufacturer);

$select = $mod->sumAmountSales_details($invoice_no);
$total = mysqli_fetch_array($select);
$new_total = $total["total"];
$new_balance = $new_total-$deposit;

$mod->updateTotalAfterReturn($new_total,$new_balance,$invoice_no);

$mod->deleteSalesDetailsReturn($invoice_no); 
$mod->deleteSalesReturn($invoice_no);

$show_debits = $mod->showDebitTotalPaidTotalBal($customer_name,$address);
$row = mysqli_fetch_array($show_debits);
$dbtotal_deposit = $row["deposit"];
$dbtotal_bal = $row["balance"];
$total_deposit = $dbtotal_deposit + $return_amount;
$total_bal1 = $dbtotal_bal - $return_amount;
$total_bal2 = $dbtotal_bal - $return_amount;
if (mysqli_num_rows($show_debits) > 0){
	$mod->updateDebits($total_deposit,$total_bal1,$customer_name,$address);
	$mod->insertDebitsDetailsReturn($customer_name, $address, $debit_total, $return_amount,$total_deposit,$total_bal1,$total_bal2, $staff_name, $date,$comment);
	
	$select =  $mod->showReturnEach($invoice_no);
	if (mysqli_num_rows($select) > 0){
		$mod->updateEachReturn($invoice_no,$return_amount,$staff_name,$date);
	}else{
		$mod->insertEachReturn($customer_name, $address, $invoice_no, $payment_type, $return_amount, $staff_name, $date);
	
	}
	
	$eachReturnDetails = $mod->showReturnEachDetails($invoice_no,$productname,$model,$manufacturer);
	if (mysqli_num_rows($eachReturnDetails) > 0){
		$mod->updateEachReturnDetails($invoice_no,$productname,$model,$manufacturer,$return_qty,$return_amount,$staff_name,$date);
	}else{
		$mod->insertEachReturnDetails($customer_name,$address,$invoice_no,$productname,$model,$manufacturer,$return_qty,$price,$return_amount,$staff_name,$date);
	
	}
	// header("location:sales_history_details.php?invoice= $invoice_no");
	echo "<script>
	location.reload();
	</script>";
}else{
	$select =  $mod->showReturnEach($invoice_no);
	if (mysqli_num_rows($select) > 0){
		$mod->updateEachReturn($invoice_no,$return_amount,$staff_name,$date);
	}else{
		$mod->insertEachReturn($customer_name, $address, $invoice_no, $payment_type, $return_amount, $staff_name, $date);
	
	}
	
	$eachReturnDetails = $mod->showReturnEachDetails($invoice_no,$productname,$model,$manufacturer);
	if (mysqli_num_rows($eachReturnDetails) > 0){
		$mod->updateEachReturnDetails($invoice_no,$productname,$model,$manufacturer,$return_qty,$return_amount,$staff_name,$date);
	}else{
		$mod->insertEachReturnDetails($customer_name,$address,$invoice_no,$productname,$model,$manufacturer,$return_qty,$price,$return_amount,$staff_name,$date);
	
	}
	// header("location:sales_history_details.php?invoice= $invoice_no");
	echo "<script>
	location.reload();
	</script>";
}

?>
	<!-- customer_name address invoice_no payment_type total cash transfer deposit balance	staff_name	date -->
