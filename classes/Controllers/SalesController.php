<?php

class SalesController extends ControllerV2
{
    public function generateInvoice()
    {
        $select = $this->fetchResult("sales", order_by: "id DESC", limit: 1);
        $row = mysqli_fetch_array($select);
        $invoice_no_db = $row["invoice_no"] ?? '00000000'; // fallback if null
        $invoice_no2 = (int)$invoice_no_db + 1;

        // Format with leading zeros up to 8 digits
        $invoice_no_formatted = str_pad($invoice_no2, 8, '0', STR_PAD_LEFT);

        return $invoice_no_formatted;
    }
    public function onlineSales()
    {
        if (isset($_POST["checkout"])) {
            $this->invoiceLock();

            $orderCtr = new OrdersController();
            $orders = $orderCtr->order();
            $order = $orders->fetch_assoc();
            $customer_name = $order['name'];
            $address = $order['address'];

            $customer_type = $order['customer_type'] ?? 'wholesale';

            $date = date('d-m-Y');
            $cash = $_POST["cash"];
            $transfer = $_POST["transfer"];
            $pos = $_POST["pos"];
            $transport = $_POST["transport"] ?? 0;
            $paid = $_POST["paid"];
            $balance = $_POST["balance"];
            $pos_type = $_POST["pos_type"];
            $pos_charges = $_POST["pos_charges"] ?? 0;
            $total = str_replace(",", "", $_POST["totalAmount"]);
            $shared = new Shared();
            $staff = $shared->getFullname();
            $username = $shared->getUsername();
            $status = "pending";
            $comment = "New Goods Bought";

            // Generate unique invoice number
            do {
                $invoice_no = $this->generateInvoice();
                $checkInvoiceExist = $this->fetchResult("sales", ["invoice_no=$invoice_no"]);
            } while (mysqli_num_rows($checkInvoiceExist) > 0);

            $bill_type = $this->determineBillType($cash, $transfer, $pos, $balance);

            $product_names = $_POST['product_name'];

            $models = $_POST['model'];
            $manufacturers = $_POST['manufacturer'];
            $quantities = $_POST['quantity'];
            $prices = $_POST['price'];
            $qty_rem = $_POST['qty_rem'];

            // Stock check
            foreach ($_POST['availability_status'] as $status) {
                if (strtolower($status) == 'not available') {
                    echo "<script>alert('One or more products are not available in sufficient quantity! Please remove them.')</script>";
                    return;
                }
            }

            // If deposit cleanup needed
            $old_deposit = $_POST['old_deposit'] ?? 0; // Default to 0 if not set

            if ($old_deposit != 0) {
                $this->trashWhere("sales", "customer_name='$customer_name'", "address='$address'", "customer_type=deposit");

                $this->trashWhere("sales_details", "customer_name='$customer_name'", "address='$address'", "customer_type = 'deposit'");
                $this->trashWhere("deposit", "customer_name='$customer_name'", "customer_address='$address'");
                $this->trashWhere("deposit_details", "customer_name='$customer_name'", "customer_address='$address'");
            }


            if (!empty($_POST["bank"])) {
                $bank_name = $_POST["bank"];
                $this->insert("bank", $customer_name, $address, $invoice_no, $customer_type, $transfer, $bank_name, 'Pending', $staff, $date);
            }

            if (!empty($_POST["pos"])) {
                $this->insert("pos", $customer_name, $address, $invoice_no, $pos_type, $pos_charges);
            }



            $this->insert("sales", $customer_name, $address, $invoice_no, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $old_deposit, $paid, $transport, $balance, $staff, $date, $username, "");

            $debitRow = mysqli_num_rows($this->fetchResult("debit", ["customer_name=$customer_name", "address=$address"]));
            $history = mysqli_fetch_array($this->fetchResult("debit_histories", ["customer_name=$customer_name", "address=$address"], order_by: "id DESC", limit: 1));
            $balancedb = $history["total_balance"];
            $prev_total_paid = $history["total_paid"];
            $total_paid = $paid + $prev_total_paid;
            $new_balance = $balance + $balancedb;

            if ($balance != 0 && $customer_name != "MR Sir" && $address != "Address") {
                if ($debitRow > 0) {
                    $this->updates(
                        "debit",
                        U::col("total = total + $total", "deposit = deposit + $paid", "balance = balance + $balance", "staff_name = $staff", "date = $date"),
                        U::where("customer_name = $customer_name", "address = $address")
                    );

                    $this->insert("debit_histories", $customer_name, $address, $total, $paid, $total_paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no);
                } else {
                    $this->insert("debit", $customer_name, $address, $total, $paid, $balance, $staff, $date);
                    $this->trashWhere("debit", "balance=0");
                    $this->insert("debit_histories", $customer_name, $address, $total, $paid, $paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no);
                }
            }

            foreach ($product_names as $i => $product_name) {
                if (stripos($qty_rem[$i], 'not available') !== false) continue;
                $amount = $quantities[$i] * $prices[$i];
                $this->insert("sales_details", $customer_name, $address, $invoice_no, $customer_type, $product_name, $models[$i], $manufacturers[$i], $quantities[$i], $prices[$i], $amount, $staff, $date);
                $quantity =  $quantities[$i];

                $this->updates(
                    "product",
                    U::col("quantity = quantity - $quantity"),
                    U::where("name = $product_name", "model = $models[$i]", "manufacturer = $manufacturers[$i]")
                );
            }

            // Mark online order completed
            $this->updates("online_orders", U::col("status=Completed"), U::where("order_id = {$order['order_id']}"));
            $_SESSION["customer_name"] = $customer_name;
            $_SESSION["address"] = $address;
            $_SESSION["invoice"] = $invoice_no;
            if ($customer_type == "retail") {
                echo "<script>window.location = '../print/director/retail_print.php'</script>";
            } else {
                echo "<script>window.location = 'print_receipt_w.php'</script>";
            }

            // $this->unlockInvoice();
        }
    }
    public function updatePayment($data)
    {
        $shared = new Shared();
        $invoice_no = $data["invoice_no"];
        $deposit = (int)$data["deposit"];
        $bank_name = $data["bank"];
        $customer_name = $data["customer_name"];
        $address = $data["address"];
        $date = date("d-m-Y");
        $staff = $shared->getFullname();
        $customer_type = $data["customer_type"];
        $new_transfer = (int)$data["new_transfer"];
        $new_cash = (int)$data["new_cash"];
        $new_pos = (int)$data["new_pos"];
        $total = (int)$data["total"];

        $comment = "New Goods Bought";
        $status = "pending";
        $total_paid = $new_transfer + $new_cash + $new_pos;
        $new_balance = $total - $total_paid;
        $new_payment = $total_paid - $deposit;

        global $payment_type;

        $payment_type = $this->determineBillType($new_cash, $new_transfer, $new_pos, $new_balance);


        // Handle transfer record
        $bank_exist = $this->fetchResult("bank", ["invoice_no = $invoice_no"]);
        if (mysqli_num_rows($bank_exist) > 0) {
            if ($new_transfer == 0) {
                $this->trashWhere("bank", "invoice_no = $invoice_no");
            } else {
                $this->updates("bank", U::col(
                    "transfer_amount = $new_transfer",
                    "bank_name = $bank_name",
                    "staff = $staff",
                    "date = $date"
                ), U::where("invoice_no = $invoice_no"));
            }
        } else {
            if ($new_transfer == 0) {
                $this->trashWhere("bank", "invoice_no = $invoice_no");
            } else {
                $this->insert("bank", $customer_name, $address, $invoice_no, $customer_type, $new_transfer, $bank_name, $status, $staff, $date);
            }
        }

        // Handle debit updates
        $check_debit_histories = $this->fetchResult("debit_histories", ["invoice_no = $invoice_no"]);
        $check_debit = $this->fetchResult("debit", ["customer_name = $customer_name", "address = $address"]);

        if (mysqli_num_rows($check_debit_histories) > 0) {
            $history = mysqli_fetch_assoc($check_debit_histories);

            $updated_deposit = $history["deposit"] + $new_payment;
            $updated_total_deposit = $history["total_paid"] + $new_payment;
            $updated_balance = $history["balance"] - $new_payment;
            $updated_total_balance = $history["total_balance"] - $new_payment;

            $this->updates("debit", U::col(
                "deposit = deposit + $new_payment",
                "balance = balance - $new_payment"
            ), U::where("customer_name = $customer_name", "address = $address"));

            $this->updates("debit_histories", U::col(
                "deposit = $updated_deposit",
                "total_paid = $updated_total_deposit",
                "balance = $updated_balance",
                "total_balance = $updated_total_balance"
            ), U::where("invoice_no = $invoice_no"));

            $this->trashWhere("debit", "balance = 0");
        } elseif ($new_balance != 0) {
            if (mysqli_num_rows($check_debit) > 0) {
                $this->updates("debit", U::col(
                    "deposit = deposit + $new_payment",
                    "balance = balance - $new_payment"
                ), U::where("customer_name = $customer_name", "address = $address"));

                $this->insert("debit_histories", $customer_name, $address, $total, $total_paid, $new_balance, $staff, $date, $comment, $invoice_no);
            } else {
                $this->insert("debit", $customer_name, $address, $total, $total_paid, $new_balance, $staff, $date);
                $this->insert("debit_histories", $customer_name, $address, $total, $total_paid, $new_balance, $staff, $date, $comment, $invoice_no);
            }

            $this->trashWhere("debit", "balance = 0");
        }

        // Final update on sales table


        $this->updates("sales", U::col(
            "transfer = $new_transfer",
            "cash = $new_cash",
            "pos = $new_pos",
            "deposit = $total_paid",
            "balance = $new_balance",
            "payment_type = \$payment_type"
        ), U::where("invoice_no = $invoice_no"));

        echo "<script>location.reload();</script>";
    }

    public function determineBillType($cash, $transfer, $pos, $balance)
    {
        $types = [];
        if ($cash > 0) $types[] = "Cash";
        if ($transfer > 0) $types[] = "Transfer";
        if ($pos > 0) $types[] = "POS";
        if ($balance > 0) $types[] = "Debit";
        return implode("/", $types);
    }

    public function sales()
    {
        if (isset($_POST["generate_bill"])) {

            if (isset($_SESSION["cart"])) {
                // obtain a lock on the sales table
                $this->invoiceLock();
                $err = false;

                $customer_type = $_POST["customer_type"];
                if (empty($_POST["title"])) {
                    echo "<script>alert('You must Fill Customer Title') </script>";
                    $err = true;
                } else {
                    $title = $_POST["title"];
                }
                if (empty($_POST["customer_name"])) {
                    echo "<script>alert('You must Fill Customer Name') </script>";
                    $err = true;
                } else {
                    $customer_name = $title . " " . $_POST["customer_name"];
                }
                if (empty($_POST["address"])) {
                    echo "<script>alert('You must Fill Customer Address') </script>";
                    $err = true;
                } else {
                    $address = $_POST["address"];
                }
                $pos_type = $_POST["pos_type"];
                $transport = $_POST["transport"];
                $old_deposit = $_POST['old_deposit'];
                $invoice_no = $_POST["invoice_no"];
                $_SESSION["customer_name"] = $customer_name;
                $_SESSION["address"] = $address;

                $date = $_POST["date"];
                $cash = $_POST["cash"];
                $transfer = $_POST["transfer"];
                $pos = $_POST["pos"];
                $pos_charges = $_POST["pos_charges"];
                $paid = $_POST["deposit"];
                $balance = $_POST["balance"];

                // Customer Name and Address Validation
                $normalized_name = strtolower(trim($customer_name));
                $normalized_address = strtolower(trim($address));

                if (($normalized_name === "mr sir") || $normalized_address === "address") {
                    if ((float)$balance > 0) {
                        echo "<script>alert('Customer name or address is invalid because this is debit. Please enter the right customer name and address to proceed. Thanks.');</script>";
                        return;
                    }
                }
                $total = $_POST["tot"];
                $shared = new Shared();
                $staff = $shared->getFullname();
                $username = $shared->getUsername();
                $_SESSION['active_role'] = $shared->getRole();
                $status = "pending";

                $bill_type = $this->determineBillType($cash, $transfer, $pos, $balance);
                $comment = "New Goods Bought";
                do {
                    $invoice_no = $this->generateInvoice();
                    $checkInvoiceExist = $this->fetchResult("sales", ["invoice_no=$invoice_no"]);
                } while (mysqli_num_rows($checkInvoiceExist) > 0);
                // Check stock for all items in the cart
                $stock_check_failed = false;
                $max = isset($_SESSION["cart"]) ? sizeof($_SESSION['cart']) : 0;

                for ($i = 0; $i < $max; $i++) {
                    $productname_session = "";
                    $model_session = "";
                    $manufacturer_session = "";
                    $quantity_session = 0;

                    if (isset($_SESSION['cart'][$i])) {
                        foreach ($_SESSION["cart"][$i] as $key => $val) {
                            if ($key == "productname") {
                                $productname_session = $val;
                            } elseif ($key == "model") {
                                $model_session = $val;
                            } elseif ($key == "manufacturer") {
                                $manufacturer_session = $val;
                            } elseif ($key == "quantity") {
                                $quantity_session = $val;
                            }
                        }

                        if (!empty($productname_session)) {

                            $qty_remaining = '';
                            if (!$this->isStockAvailable($productname_session, $model_session, $manufacturer_session, $quantity_session, $qty_remaining)) {
                                echo "<script>alert('{$qty_remaining}')</script>";
                                $stock_check_failed = true;
                                break;
                            }
                        }
                    }
                }

                // If stock check failed, do not proceed further
                // if ($stock_check_failed) {
                //     $this->unlockInvoice();
                //     return;
                // }


                if ($old_deposit != 0) {
                    $this->trashWhere("sales", "customer_name='$customer_name'", "address='$address'", "customer_type=deposit");

                    $this->trashWhere("sales_details", "customer_name='$customer_name'", "address='$address'", "customer_type = 'deposit'");
                    $this->trashWhere("deposit", "customer_name='$customer_name'", "customer_address='$address'");
                    $this->trashWhere("deposit_details", "customer_name='$customer_name'", "customer_address='$address'");
                }
                if (!($err)) {

                    $_SESSION["invoice"] = $invoice_no;
                    if (!empty($_POST["bank"])) {
                        $bank_name = $_POST["bank"];
                        $this->insert("bank", $customer_name, $address, $invoice_no, $customer_type, $transfer, $bank_name, 'Pending', $staff, $date);
                    }

                    if (!empty($_POST["pos"])) {
                        $this->insert("pos", $customer_name, $address, $invoice_no, $pos_type, $pos_charges);
                    }

                    // Insert Into Sales Table
                    $this->insert("sales", $customer_name, $address, $invoice_no, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $old_deposit, $paid, $transport, $balance, $staff, $date, $username, "");



                    $debitRow = mysqli_num_rows($this->fetchResult("debit", ["customer_name=$customer_name", "address=$address"]));
                    $history = mysqli_fetch_array($this->fetchResult("debit_histories", ["customer_name=$customer_name", "address=$address"], order_by: "id DESC", limit: 1));
                    $balancedb = $history["total_balance"];
                    $prev_total_paid = $history["total_paid"];
                    $total_paid = $paid + $prev_total_paid;
                    $new_balance = $balance + $balancedb;
                    if ($balance != 0) {
                        if ($debitRow > 0) {
                            $this->updates(
                                "debit",
                                U::col("total = total + $total", "deposit = deposit + $paid", "balance = balance + $balance", "staff_name = $staff", "date = $date"),
                                U::where("customer_name = $customer_name", "address = $address")
                            );

                            $this->insert("debit_histories", $customer_name, $address, $total, $paid, $total_paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no);
                        } else {
                            $this->insert("debit", $customer_name, $address, $total, $paid, $balance, $staff, $date);
                            $this->trashWhere("debit", "balance=0");
                            $this->insert("debit_histories", $customer_name, $address, $total, $paid, $paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no);
                        }
                    }

                    $id = 1;
                    $qty_found = 0;
                    $max = 0;
                    $quantity_session = 0;
                    if (isset($_SESSION["cart"])) {
                        $max = sizeof($_SESSION['cart']);
                    }

                    for ($i = 0; $i < $max; $i++) {
                        $productname_session = "";
                        $model_session = "";
                        $manufacturer_session = "";

                        if (isset($_SESSION['cart'][$i])) {
                            foreach ($_SESSION["cart"][$i] as $key => $val) {
                                if ($key == "productname") {
                                    $productname_session = $val;
                                } elseif ($key == "model") {
                                    $model_session = $val;
                                } elseif ($key == "manufacturer") {
                                    $manufacturer_session = $val;
                                } elseif ($key == "quantity") {
                                    $quantity_session = $val;
                                } elseif ($key == "price") {
                                    $price_session = $val;
                                }
                            }
                            if (!empty($productname_session)) {
                                $amount = (int) $quantity_session * (int) $price_session;
                                $qty = (int) ($quantity_session);
                                //

                                $this->insert("sales_details", $customer_name, $address, $invoice_no, $customer_type, $productname_session, $model_session, $manufacturer_session, $quantity_session, $price_session, $amount, $staff, $date);

                                $this->updates(
                                    "product",
                                    U::col("quantity = quantity - $qty"),
                                    U::where("name = $productname_session", "model = $model_session", "manufacturer = $manufacturer_session")
                                );
                            }
                        }
                    }
                    if ($_POST["customer_type"] == "retail") {
                        Session::unset("cart");
                        echo "<script> window.location = '../print/retail_print.php' </script>";
                        // echo "<script> window.location = '../print/retail_print.php?view=html' </script>";
                    } else {
                        Session::unset("cart");
                        echo "<script> window.location = 'print_receipt_w.php' </script>";
                    }
                }
            } else {
                echo "<script>console.log('Session cart not found')</script>";
            }
        }
        // $this->unlockInvoice();
    }
    private function isStockAvailable(string $productName, string $model, string $manufacturer, int $requestedQty, &$qty_remaining = ''): bool
    {
        $query = $this->fetchResult(
            "product",
            where: [
                "name=$productName",
                "model=$model",
                "manufacturer=$manufacturer"
            ],
            cols: "quantity"
        );

        if (mysqli_num_rows($query) === 0) {
            $qty_remaining = "$productName $model $manufacturer not found in stock.";
            return false;
        }

        $row = mysqli_fetch_assoc($query);
        $stockQty = (int) $row['quantity'];

        if ($requestedQty > $stockQty) {
            $qty_remaining = "$stockQty $productName $model $manufacturer remaining in stock.";
            return false;
        }

        return true;
    }
    public function confirmTransfer()
    {
        if (isset($_GET["invoice_no"])) {
            $invoice_no = $_GET["invoice_no"];
            $bank_name = $_GET["bank_name"];
            $this->updates("sales",
            U::col( "bank=$bank_name"),
            U::where("invoice_no=$invoice_no"));
            $this->trashWhere("bank","invoice_no = $invoice_no");
            // new Redirect("confirm_transfer.php");
            // echo "<script>
            //     location.reload();
            //     </script>";

        }
    }
    public function showSalesCustomerName()
    {
        return $this->fetchResult("sales", distinct: "customer_name");
    }
    public function showSalesCustomerAddress()
    {
        return $this->fetchResult("sales", distinct: "address");
    }
    public function filterProductName()
    {
        return $this->fetchResult("product", cols: "name", group_by: "name");
    }
    public function filterModel($productname)
    {
        return $this->fetchResult("product", cols: "model", where: ["name=$productname"], group_by: "model");
    }
    public function filterManufacturer($productname, $model)
    {
        return $this->fetchResult("product", cols: "manufacturer", where: ["name=$productname", "model=$model"], group_by: "manufacturer");
    }
    public function getProduct($product_name, $model, $manufacturer)
    {
        return $this->fetchResult("product", cols: "cprice,wprice,rprice,quantity,product_id", where: ["name=$product_name", "model=$model", "manufacturer=$manufacturer"])->fetch_assoc();
    }
    public function saveSupplyCheck()
    {
        if (isset($_POST["print"])) {

            $invoice_no = $_SESSION["invoice"];
            $result = mysqli_fetch_assoc($this->fetchResult("sales", where: ["invoice_no = $invoice_no"], limit: 1));
            $this->insert("supply_check", $result["customer_name"], $result["address"], $result["invoice_no"], $_POST["supplied_by"], $_POST["checked_by"]);
            Session::unset("invoice");
            Session::unset("customer_name");
            Session::unset("address");

            new Redirect("wholesales.php");
        }
    }
}
