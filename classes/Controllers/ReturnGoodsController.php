<?php
class ReturnGoodsController extends ControllerV2
{
    public function returnAllGoods()
    {

        if (isset($_GET["invoice_no1"])) {
            $invoice_no = $_GET["invoice_no1"];
            $sales = $this->fetchResult("sales", ["invoice_no =$invoice_no"]);
           
            $sale = mysqli_fetch_assoc($sales);
            $customer_name = $sale["customer_name"];
            $address = $sale["address"];
            $invoice_no = $sale["invoice_no"];
            $customer_type = $sale["customer_type"];
            $payment_type = $sale["payment_type"];
            $total = $sale["total"];
            $cash = $sale["cash"];
            $transfer = $sale["transfer"];
            $pos = $sale["pos"];
            $old_deposit = $sale["old_deposit"];
            $deposit = $sale["deposit"];
            $transport = $sale["transport"];
            $balance = $sale["balance"];
            $shared = new Shared();
            $username = $_SESSION[$shared->getRole() . "username"] ?? "";
            $bank = $sale["bank"];
            $date = date("d-m-Y");
            $staff = $shared->getFullname();
            // $new_deposit = $total + $deposit;
            // $new_balance = $balance - $total;
            // $new_balance1 = $balance - $total;
            $debit_total = 0;

            // $show_debits = $this->showDebitTotalPaidTotalBal($customer_name, $address);
            $debits = $this->fetchResult("debit", ["customer_name=$customer_name", "address=$address"]);
            $debit = mysqli_fetch_assoc($debits);
            $dbtotal_deposit = $debit["deposit"];
            $dbtotal_bal = $debit["balance"];
            $total_deposit = $dbtotal_deposit + $total;
            $total_bal = $dbtotal_bal - $total;


            if (mysqli_num_rows($debits) > 0) {

                $comment = "All Goods Returned for " . $customer_name . " " . $address;
                // $this->insertAllReturn($customer_name, $address, $invoice_no, $payment_type, $total, $cash, $transfer, $deposit, $balance, $staff, $date);

                $this->updates(
                    "debit",
                    U::col("deposit = $total_deposit", "balance = $total_bal"),
                    U::where("customer_name = $customer_name", "address = $address")
                );
                $this->insert("debit_histories", $customer_name, $address, $debit_total, $total, $total_deposit, $total_bal, $total_bal, $staff, $date, $comment,$invoice_no);
                $this->trashWhere("debit", "balance=0");
            }
            $this->insert("return_goods", $customer_name, $address, $invoice_no, $customer_type, $payment_type, $total, $cash, $transfer, $pos, $old_deposit, $deposit, $transport, $balance, $staff, $date, $username, $bank);
            $this->trashWhere("sales", "invoice_no=$invoice_no");
            $sale_details = $this->fetchResult("sales_details",["invoice_no=$invoice_no"]);
            while ($sale_detail = mysqli_fetch_assoc($sale_details)) {
                $productname = $sale_detail["product_name"];
                $model = $sale_detail["model"];
                $manufacturer = $sale_detail["manufacturer"];
                $quantity = $sale_detail["quantity"];
                $price = $sale_detail["price"];
                $amount = $sale_detail["amount"];
                // $date1 = $sale_detail["date"];

                $this->insert("return_goods_details", $customer_name, $address, $invoice_no, $productname, $model, $manufacturer, $quantity, $price, $amount, $staff, $date);
                $this->updates(
                    "product",
                    U::col("quantity = quantity+$quantity"),
                    U::where("name = $productname", "model = $model", "manufacturer = $manufacturer")
                );
                $this->trashWhere("sales_details", "invoice_no=$invoice_no");
            }
            header("location:sales_history.php");
        }
    }
    public function returnAGood($data)
    {
        $shared = new Shared();
        $return_qty = $data["returnQty"];
        $quantity = $data["quantity"];
        $productname = $data["productname"];
        $model = $data["model"];
        $manufacturer = $data["manufacturer"];
        $price = $data["price"];
        $amount = $data["amount"];
        $invoice_no = $data["invoice_no"];

        $customer_name = $data["customer_name"];
        $address = $data["address"];
        $payment_type = $data["payment_type"];
        $cash = $data["cash"];
        $transfer = $data["transfer"];
        $deposit = $data["deposit"];
        $balance = $data["balance"];
        // $date = $data["date"];
        $date = date("d-m-Y");
        $staff_name = $shared->getFullname();
        // $staff_name = $data["staff"];
        $comment = "Some Goods Returned for ".$customer_name." ".$address;
        $debit_total = 0;

        $rem_qty = $quantity - $return_qty;
        $new_amount = $price * $rem_qty;
        $return_amount = $price * $return_qty;

        // Update sales_details table after each return
        $this->updates(
            "sales_details",
            U::col("quantity = $rem_qty", "amount = $new_amount"),
            U::where("product_name = $productname", "model = $model", "manufacturer = $manufacturer", "invoice_no = $invoice_no")
        );


        // Update stock after each return
        $this->updates(
            "product",
            U::col("quantity = quantity+$return_qty"),
            U::where("name = $productname", "model = $model", "manufacturer = $manufacturer")
        );


        // fetch total amount of sales after return
        $total_select = $this->fetchResult("sales_details", cols: "SUM(amount) AS total", where: ["invoice_no = $invoice_no"]);

        $total = mysqli_fetch_assoc($total_select);
        $new_total = $total["total"];
        $new_balance = $new_total - $deposit;


        // Update total after return
        // $mod->updateTotalAfterReturn($new_total, $new_balance, $invoice_no);
        $this->updates(
            "sales",
            U::col("total = $new_total", "balance = $new_balance"),
            U::where("invoice_no = $invoice_no")
        );

        // Delete sales_details and sales after each return

        // $mod->deleteSalesDetailsReturn($invoice_no);
        $this->trashWhere("sales_details", "quantity =0", "invoice_no = $invoice_no");
        // $mod->deleteSalesReturn($invoice_no);
        $this->trashWhere("sales", "total =0", "invoice_no = $invoice_no");


        // $show_debits = $mod->showDebitTotalPaidTotalBal($customer_name, $address);
        $fetch_debit = $this->fetchResult("debit", ["customer_name = $customer_name", "address = $address"]);

        if (mysqli_num_rows($fetch_debit) > 0) {
            // fetch total paid and total balance from debit table
            $debit = mysqli_fetch_assoc($fetch_debit);
            $dbtotal_deposit = $debit["deposit"];
            $dbtotal_bal = $debit["balance"];
            $total_deposit = $dbtotal_deposit + $return_amount;
            $total_bal1 = $dbtotal_bal - $return_amount;
            $total_bal2 = $dbtotal_bal - $return_amount;
            // Update debit table after each return
            // $mod->updateDebits($total_deposit, $total_bal1, $customer_name, $address);
            $this->updates(
                "debit",
                U::col("deposit = $total_deposit", "balance = $total_bal1"),
                U::where("customer_name = $customer_name", "address = $address")
            );
            // Insert debit_details after each return
            // $mod->insertDebitsDetailsReturn($customer_name, $address, $debit_total, $return_amount, $total_deposit, $total_bal1, $total_bal2, $staff_name, $date, $comment.$invoice_no);
            $this->insert("debit_histories", $customer_name, $address, $debit_total, $return_amount, $total_deposit, $total_bal1, $total_bal2, $staff_name, $date, $comment, $invoice_no);
        }
        // Check existing return to update or insert new one
        // $select =  $mod->showReturnEach($invoice_no);
        $count_return_each = $this->fetchResult("return_each_goods", ["invoice_no = $invoice_no"]);
        if (mysqli_num_rows($count_return_each) > 0) {
            // $mod->updateEachReturn($invoice_no, $return_amount, $staff_name, $date);
            $this->updates(
                "return_each_goods",
                U::col("total = total+$return_amount", "staff_name = $staff_name", "date= $date"),
                U::where("invoice_no = $invoice_no")
            );
        } else {
            // $mod->insertEachReturn($customer_name, $address, $invoice_no, $payment_type, $return_amount, $staff_name, $date);
            $this->insert("return_each_goods", $customer_name, $address, $invoice_no, $payment_type, $return_amount, $staff_name, $date);
        }

        // Check existing return details to update or insert new one
        // $eachReturnDetails = $mod->showReturnEachDetails($invoice_no, $productname, $model, $manufacturer);
        $count_return_details = $this->fetchResult("return_goods_details", where: ["invoice_no = $invoice_no", "product_name = $productname", "model = $model", "manufacturer = $manufacturer"]);
        if (mysqli_num_rows($count_return_details) > 0) {
            // $mod->updateEachReturnDetails($invoice_no, $productname, $model, $manufacturer, $return_qty, $return_amount, $staff_name, $date);
            $this->updates(
                "return_goods_details",
                U::col("quantity = quantity+$return_qty", "amount = amount+$return_amount", "staff_name = $staff_name", "date= $date"),
                U::where("product_name = $productname", "model = $model", "manufacturer = $manufacturer", "invoice_no = $invoice_no")
            );
        } else {
            // $mod->insertEachReturnDetails($customer_name, $address, $invoice_no, $productname, $model, $manufacturer, $return_qty, $price, $return_amount, $staff_name, $date);
            $this->insert("return_goods_details", $customer_name, $address, $invoice_no, $productname, $model, $manufacturer, $return_qty, $price, $return_amount, $staff_name, $date);
        }
        // header("location:sales_history_details.php?invoice= $invoice_no");
        echo "<script>
                location.reload();
                </script>";
    }
}
