<?php
class Controller extends Model
{
    //<============================================ USER START=================================================>//

    public function logout()
    {
        session_destroy();
        header("location:../index.php");
    }
    
    public function oldValue($value)
    {
        if (isset($_POST["$value"])) {
            echo $_POST["$value"];
        }
    }
    public function oldSelect($value)
    {
        if (isset($_POST["$value"])) { ?>
            <option><?php echo $_POST["$value"] ?></option>

            <?php
        }
    }
    public function loginUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = mysqli_escape_string($this->connect(), $_POST["username"]);
            $password = md5(mysqli_escape_string($this->connect(), $_POST["password"]));
            $mac_address = mysqli_escape_string($this->connect(), $_POST['mac_address']);

            // Retrieve the MAC address from the form submission

            // Define the allowed MAC addresses
              $allowed_mac_addresses = [
                "D8:80:83:D9:FF:4C", // my system
                "64:00:6A:52:01:EC", // desktop 1 mac 1
                "00:E0:24:51:70:46",  // desktop 1 mac 2
                "6C:3B:E5:13:27:11",  // desktop 2 mac 1
                "18:99:F5:82:8E:78",  // desktop 2 mac 2
                "6C:3B:E5:1B:40:07",  // desktop 3 mac 1
                "00:E0:20:61:44:A7",  // desktop 3 mac 2
                "E0:20:61:44:A7:",
                "7C:57:58:4F:8E:14",  // desktop 4 mac 1
                "F0:A6:54:7C:3A:9A",  // desktop 4 mac 2
                "F0:A6:54:7C:3A:99",  // desktop 4 mac 3
                "40:A8:F0:5E:E3:15",  // desktop 5 mac 1
                "20:E9:17:0C:C4:EE",   // desktop 5 mac 2
                "E0:3F:49:DB:AC:B4",  
                "54:35:30:12:A2:4F",  
                "54:35:30:12:A2:50",  
                "70:5A:0F:36:2E:5F",  
                "00:FF:2F:EB:9E:36",  
                "00:FF:DC:0E:16:31",  
                "00:FF:AF:9C:73:45",  
                "00:E0:20:61:44:39",
                "3C:A9:F4:6A:93:80",  
                "9C:B6:54:9F:B7:D0",  
                "0C:84:DC:E5:DC:C9",
                "C8:4D:CE:5D:CC:9",
                "E0:20:61:44:39:",
                "00:E0:20:61:44:39",
                "64:00:6A:52:01:EC", 
                "00:E0:24:51:70:46", 
                "6C:3B:E5:13:27:11", 
                "18:99:F5:82:8E:78", 
                "6C:3B:E5:11:EF:43", 
                "00:0F:00:49:6D:B3",
                "6C:3B:E5:1B:40:07",
                "00:E0:20:61:44:A7",
                "9C:B6:54:9F:B7:D0",
                "3C:A9:F4:6A:93:80",
                "0C:84:DC:E5:DC:C9",
                "20:E9:17:0C:C4:EE",
                "40:A8:F0:5E:E3:15",
                "8D:57:C3:0F:56:45",
                "6C:3B:E5:13:27:11",  
                "18:99:F5:82:8E:78",
                "83:5D:CC:23:BB:4F" 
            ];
            
            // Get the current time and day of the week (0 = Sunday, 6 = Saturday)
            $current_time = strtotime(date("H:i"));
            $current_day = date("w");
    
            // Check if today is Sunday (0)
            if ($current_day == 0) {
                echo "<div class='alert alert-danger text-center'>
                    <strong> Access denied: </strong>Login is not allowed on Sundays.
                </div>";
                return;
            }

            // Define office hours (24-hour format)
            $start_time = strtotime("06:30");
            $end_time = strtotime("22:30");

            // Get the current time
            $current_time = strtotime(date("H:i"));

            // // Check if the MAC address is allowed and if the current time is within office hours
            if (in_array($mac_address, $allowed_mac_addresses) && ($current_time >= $start_time && $current_time <= $end_time)) {
                
                // Proceed with login
                $this->userLogin($username, $password);
                
            } else {
                // Deny access
                if (!in_array($mac_address, $allowed_mac_addresses)) {
                    echo "<div class='alert alert-danger text-center'>
                        <strong>Danger!</strong> Access denied: Unauthorized device!
                    </div>";
                } elseif ($current_time < $start_time || $current_time > $end_time) {
                    echo "<div class='alert alert-danger text-center'>
                        <strong>Danger!</strong> Access denied: Outside of office hours.
                    </div>";
                }
            }

        }
    }

    public function random()
    {
        $select = $this->checkInvoicer();
        $row  = mysqli_fetch_array($select);
        $invoice_no_db = $row["invoice_no"];
        $invoice_no2 = $invoice_no_db + 1;
        $invoice_no = ltrim($invoice_no2, '0');
        $zeros = strlen($invoice_no_db) - strlen(ltrim($invoice_no_db, '0'));
        if ($zeros == 0) {
            echo "00000001";
        } else {

            if (strlen($invoice_no) == 1) {
                echo "0000000" . $invoice_no2;
            } elseif (strlen($invoice_no) == 2) {
                echo "000000" . $invoice_no2;
            } elseif (strlen($invoice_no) == 3) {
                echo "00000" . $invoice_no2;
            } elseif (strlen($invoice_no) == 4) {
                echo "0000" . $invoice_no2;
            } elseif (strlen($invoice_no) == 5) {
                echo "000" . $invoice_no2;
            } elseif (strlen($invoice_no) == 6) {
                echo "00" . $invoice_no2;
            } elseif (strlen($invoice_no) == 7) {
                echo "0" . $invoice_no2;
            } else {
                echo $invoice_no2;
            }
        }
    }
    //<============================================ FUNCTION TO GENERATE INVOICE NO END =================================================>//

    //<===============================================================WHOLESALES============================================================>//
    public function sales()
    {
        if (isset($_POST["generate_bill"])) {
            if (isset($_SESSION["cart"])) {
                $this->invoiceLock();
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
                $pos_type = $_POST['pos_type'];
                $invoice_no = $_POST["invoice_no"];
                $_SESSION["customer_name"] = $customer_name;
                $_SESSION["address"] = $address;
                $date = $_POST["date"];
                $cash = $_POST["cash"];
                $transfer = $_POST["transfer"];
                $pos = $_POST["pos"];
                $pos_charges = $_POST["pos_charges"];
                $deposit = $_POST["deposit"];
                $balance = $_POST["balance"];
                $total = $_POST["tot"];
                $staff = $_SESSION["staffname"];
                $username = $_SESSION["staffusername"];
                $old_deposit = $_POST['old_deposit'];
                $transport = $_POST["transport"];

                $status = "pending";
                if ($_POST["cash"] == 0 && $_POST["transfer"] == 0 && $_POST["pos"] == 0 && $_POST["balance"] != 0) {
                    $bill_type = "Debit";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] != 0 && $_POST["pos"] == 0 && $_POST["balance"] == 0) {
                    $bill_type = "Transfer";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] == 0 && $_POST["pos"] == 0 && $_POST["balance"] == 0) {
                    $bill_type = "Cash";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] == 0 && $_POST["pos"] != 0 && $_POST["balance"] == 0) {
                    $bill_type = "POS";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] != 0 && $_POST["pos"] == 0 && $_POST["balance"] == 0) {
                    $bill_type = "Cash/Transfer";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] == 0 && $_POST["pos"] != 0 && $_POST["balance"] == 0) {
                    $bill_type = "Cash/POS";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] == 0 && $_POST["pos"] == 0 && $_POST["balance"] != 0) {
                    $bill_type = "Cash/Debit";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] != 0 && $_POST["pos"] != 0 && $_POST["balance"] == 0) {
                    $bill_type = "Cash/Transfer/POS";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] == 0 && $_POST["pos"] != 0 && $_POST["balance"] != 0) {
                    $bill_type = "Cash/POS/Debit";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] != 0 && $_POST["pos"] == 0 && $_POST["balance"] != 0) {
                    $bill_type = "Cash/Transfer/Debit";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] != 0 && $_POST["pos"] != 0 && $_POST["balance"] != 0) {
                    $bill_type = "Cash/Transfer/POS/Debit";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] != 0 && $_POST["pos"] != 0 && $_POST["balance"] == 0) {
                    $bill_type = "Transfer/POS";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] != 0 && $_POST["pos"] == 0 && $_POST["balance"] != 0) {
                    $bill_type = "Transfer/Debit";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] != 0 && $_POST["pos"] != 0 && $_POST["balance"] != 0) {
                    $bill_type = "Transfer/POS/Debit";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] == 0 && $_POST["pos"] != 0 && $_POST["balance"] != 0) {
                    $bill_type = "POS/Debit";
                }

                $comment = "New Goods Bought";

                $fetch_last_invoice_no = $this->checkInvoicer();
                $get = mysqli_fetch_array($fetch_last_invoice_no);
                $invoice_no_db = $get["invoice_no"];
                $add_invoice_no = $invoice_no_db + 1;
                $invoice_no3 = ltrim($add_invoice_no, '0');
                if (strlen($invoice_no3) == 1) {
                    $invoice_no2 = "0000000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 2) {
                    $invoice_no2 = "000000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 3) {
                    $invoice_no2 = "00000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 4) {
                    $invoice_no2 = "0000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 5) {
                    $invoice_no2 = "000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 6) {
                    $invoice_no2 = "00" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 7) {
                    $invoice_no2 = "0" . $add_invoice_no;
                } else {
                    $invoice_no2 = $add_invoice_no;
                }
                
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
                            // Perform stock check
                            if (!$this->checkStockQtyRem($productname_session, $model_session, $manufacturer_session, $quantity_session)) {
                                echo "<script>alert('{$this->qty_remaining}')</script>";
                                $stock_check_failed = true;
                                break; // Stop processing further if stock check fails
                            }
                        }
                    }
                }

                // If stock check failed, do not proceed further
                if ($stock_check_failed) {
                    $this->unlockInvoice();
                    return;
                }
                $fetch = $this->checkInvoice_noExist($invoice_no);
                if ($_POST['old_deposit'] != 0) {
                    $this->deleteSalesDeposit($customer_name, $address);
                    $this->deleteSalesDepositDetails($customer_name, $address);
                    $this->deleteDeposit($customer_name, $address);
                    $this->deleteDepositDetails($customer_name, $address);
                }
                if (!($err)) {
                    if (mysqli_num_rows($fetch) > 0) {
                        if (!(empty($_POST["bank"]))) {
                            $bank_name = $_POST["bank"];
                            $this->addBank($customer_name, $address, $invoice_no2, $customer_type, $transfer, $bank_name, $status, $staff, $date);
                        }
                        $_SESSION["invoice"] = $invoice_no2;
                        $this->addPos($customer_name, $address, $invoice_no2, $pos_type, $pos_charges);
                        $this->addSales($customer_name, $address, $invoice_no2, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $old_deposit, $deposit, $transport, $balance, $staff, $date, $username);
                        $row = mysqli_num_rows($this->checkDebit($customer_name, $address));
                        $history = mysqli_fetch_array($this->checkDebitHistories($customer_name, $address));
                        $balancedb = $history["total_balance"];
                        $depositdb = $history["deposit"];
                        $prev_total_paid = $history["total_paid"];
                        $total_paid = $deposit + $prev_total_paid;
                        $new_balance = $balance + $balancedb;
                        if ($balance != 0) {
                            if ($customer_name != "MR Sir" && $address != "Address") {
                                if ($row > 0) {
                                    $this->updateDebit($customer_name, $address, $total, $deposit, $balance, $staff, $date);
                                    $this->addtoDebitsHistory($customer_name, $address, $total, $deposit, $total_paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no2);
                                } else {
                                    $this->addDebits($customer_name, $address, $total, $deposit, $balance, $staff, $date);
                                    $this->deleteDebit();
                                    $this->addDebitsHistory($customer_name, $address, $total, $deposit, $deposit, $balance, $new_balance, $staff, $date, $comment, $invoice_no2);
                                    // $this->deleteDebitHistories();
                                }
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

                                    $this->addSalesDetails($customer_name, $address, $invoice_no2, $customer_type, $productname_session, $model_session, $manufacturer_session, $quantity_session, $price_session, $amount, $staff, $date);
                                    $this->updateQty($qty, $productname_session, $model_session, $manufacturer_session);
                                }
                            }
                        }
                        if ($_POST["customer_type"] == "retail") {
                            Session::unset("cart");
                            echo "<script> window.location = '../print/staff/retail_print.php' </script>";
                        } else {
                            Session::unset("cart");
                            echo "<script> window.location = 'print_receipt_w.php' </script>";
                        }
                    } else {
                        if (!(empty($_POST["bank"]))) {
                            $bank_name = $_POST["bank"];
                            $this->addBank($customer_name, $address, $invoice_no, $customer_type, $transfer, $bank_name, $status, $staff, $date);
                        }
                        $_SESSION["invoice"] = $invoice_no;
                        $this->addPos($customer_name, $address, $invoice_no, $pos_type, $pos_charges);
                        $this->addSales($customer_name, $address, $invoice_no, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $old_deposit, $deposit, $transport, $balance, $staff, $date, $username);
                        $row = mysqli_num_rows($this->checkDebit($customer_name, $address));
                        $history = mysqli_fetch_array($this->checkDebitHistories($customer_name, $address));
                        $balancedb = $history["total_balance"];
                        $depositdb = $history["deposit"];
                        $prev_total_paid = $history["total_paid"];
                        $total_paid = $deposit + $prev_total_paid;
                        $new_balance = $balance + $balancedb;
                        if ($balance != 0) {
                            if ($customer_name != "MR Sir" && $address != "Address") {
                                if ($row > 0) {
                                    $this->updateDebit($customer_name, $address, $total, $deposit, $balance, $staff, $date);
                                    $this->addtoDebitsHistory($customer_name, $address, $total, $deposit, $total_paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no);
                                } else {
                                    $this->addDebits($customer_name, $address, $total, $deposit, $balance, $staff, $date);
                                    $this->deleteDebit();
                                    $this->addDebitsHistory($customer_name, $address, $total, $deposit, $deposit, $balance, $new_balance, $staff, $date, $comment, $invoice_no);
                                    // $this->deleteDebitHistories();
                                }
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

                                    $this->addSalesDetails($customer_name, $address, $invoice_no, $customer_type, $productname_session, $model_session, $manufacturer_session, $quantity_session, $price_session, $amount, $staff, $date);
                                    $this->updateQty($qty, $productname_session, $model_session, $manufacturer_session);
                                }
                            }
                        }
                        if ($_POST["customer_type"] == "retail") {
                            Session::unset("cart");
                            echo "<script> window.location = '../print/staff/retail_print.php' </script>";
                        } else {
                            Session::unset("cart");
                            echo "<script> window.location = 'print_receipt_w.php' </script>";
                        }
                    }
                }
                $this->unlockInvoice();
            }
        }
    }
   

    //=======================================================================
    public function viewSalesDetail($tablename)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice']) {
                $row = mysqli_fetch_array($this->showInvoiceSales1($invoice, $customer_name, $address));
                echo $row["$tablename"];
            }
        }
    }

    public function viewSalesReceipt($tablename)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice']) {
                $row = mysqli_fetch_array($this->showInvoiceSales1($invoice, $customer_name, $address));
                return $row["$tablename"];
            }
        }
    }
    public function viewSalesDetails()
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice']) {
                return $row = $this->showInvoiceSalesDetails1($invoice, $customer_name, $address);
            }
        }
    }
    public function supplyCheck($tablename)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice']) {
                $row = mysqli_fetch_array($this->showSupplyCheck($invoice, $customer_name, $address));
                return $row["$tablename"];
            }
        }
    }
    public function viewPosType($tablename)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice']) {
                $row = mysqli_fetch_array($this->showPos($customer_name, $address, $invoice));
                return $row["$tablename"];
            }
        }
    }

    public function viewSalesDetailDebit()
    {
        if (isset($_GET['invoice'])) {
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            return $this->showDebitInvoice($customer_name, $address);
        }
    }



    //===============================================Return Goods Start=================================================
    public function returnAllGoods()
    {
        if (isset($_GET["invoice_no1"])) {
            $invoice = $_GET["invoice_no1"];
            $select1 = $this->showInvoiceSales($invoice);
            $row1 = mysqli_fetch_array($select1);
            $customer_name = $row1["customer_name"];
            $address = $row1["address"];
            $invoice_no = $row1["invoice_no"];
            $payment_type = $row1["payment_type"];
            $total = $row1["total"];
            $cash = $row1["cash"];
            $transfer = $row1["transfer"];
            $deposit = $row1["deposit"];
            $balance = $row1["balance"];
            $date = $row1["date"];
            $staff_name = $_SESSION["staffname"];

            $this->insertAllReturn($customer_name, $address, $invoice_no, $payment_type, $total, $cash, $transfer, $deposit, $balance, $date, $staff_name);
            $this->deletesales($invoice);

            $select2 = $this->showInvoiceSalesDetails($invoice);
            while ($row2 = mysqli_fetch_array($select2)) {
                $invoice_no1 = $row2["invoice_no"];
                $customer_name1 = $row2["customer_name"];
                $address1 = $row2["address"];
                $productname = $row2["product_name"];
                $model = $row2["model"];
                $manufacturer = $row2["manufacturer"];
                $quantity = $row2["quantity"];
                $price = $row2["price"];
                $amount = $row2["amount"];
                $date1 = $row2["date"];

                $this->insertAllReturnDetails($customer_name1, $address1, $invoice_no1, $productname, $model, $manufacturer, $quantity, $price, $amount, $date1);
                $this->updateReturnGoodsQty($quantity, $productname, $model, $manufacturer);
                $this->deletesalesDetails($invoice);
            }
            header("location:sales_history.php");
        }
    }

    //==============================================================CUSTOMER START================================================================//
    public function addCustomer()
    {
        if (isset($_POST["add"])) {
            $customer_name = mysqli_escape_string($this->connect(), $_POST["customername"]);
            $address = mysqli_escape_string($this->connect(), $_POST["address"]);
            $phone_no = mysqli_escape_string($this->connect(), $_POST["phone_no"]);
            $customer = $this->newCustomer($customer_name, $address, $phone_no);
            $count = mysqli_num_rows($customer);
            if ($count > 0) { ?>

                <script>
                    document.getElementById('danger').style.display = 'block';
                    document.getElementById('success').style.display = 'none';
                </script>
            <?php } else {
                $this->customerAdd($customer_name, $address, $phone_no);
            ?>
                <script>
                    document.getElementById('danger').style.display = 'none';
                    document.getElementById('success').style.display = 'block';
                    setTimeout(function() {
                        window.location.href = window.location.href
                    }, 1000);
                </script>
            <?php }
        }
    }
    public function customerDelete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_GET['id']) {
                $this->deleteCustomer($id); ?>
                <script>
                    document.getElementById('delete').style.display = 'block';
                </script>
<?php }
        }
    }
    public function customerEdit($tablename)
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_GET['id']) {
                $row = mysqli_fetch_array($this->editCustomer($id));
                echo $row["$tablename"];
            }
        }
    }
    public function customerUpdate()
    {
        if (isset($_POST["update"])) {
            $id = mysqli_escape_string($this->connect(), $_POST["id"]);
            $customer_name = mysqli_escape_string($this->connect(), $_POST["customername"]);
            $address = mysqli_escape_string($this->connect(), $_POST["address"]);
            $phone_no = mysqli_escape_string($this->connect(), $_POST["phone_no"]);

            $this->updateCustomer($id, $customer_name, $address, $phone_no);
            echo "<script>
                    document.getElementById('update').style.display='block';
                     setTimeout(function(){
                         window.location = 'add_new_customer.php'
                      }, 1000);
            </script>";
        }
    }
    public function viewReturnDetail($tablename)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            if ($_GET['invoice']) {
                $row = mysqli_fetch_array($this->showInvoiceReturn($invoice));
                echo $row["$tablename"];
            }
        }
    }
    public function viewReturnDetails()
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            if ($_GET['invoice']) {
                return $row = $this->showInvoiceReturnDetails($invoice);
            }
        }
    }
    public function debitEdit($tablename)
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_GET['id']) {
                $row = mysqli_fetch_array($this->editDebit($id));
                echo $row["$tablename"];
            }
        }
    }
    public function debitUpdate()
    {
        if (isset($_POST["update"])) {
            $id = $_POST["id"];
            $customer_name = $_POST["customer_name"];
            $address = $_POST["address"];
            $date = $_POST["date"];;
            $deposit = $_POST["deposit"];
            $balance = $_POST["balance"];
            $total = $_POST["total"];
            $pay = $_POST["pay"];
            $comment = $_POST["comment"];
            $total_paid = $deposit + $pay;
            $new_balance = $balance - $pay;
            $staff = $_SESSION["staffname"];
            $this->updateDebitinput($id, $pay, $staff, $date);
            $this->addDebitsHistoryinput($customer_name, $address, $total, $pay, $total_paid, $new_balance, $new_balance, $staff, $date, $comment);
            $this->deleteDebit();
            echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'settle_debit.php'
                     }, 2000);
            </script>";
        }
    }


    //================================================================= DEPOSIT START ==============================================================>//

    public function addDeposit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["customer_name"] && $_POST["customer_address"])) {
                $customer_name = $_POST["customer_name"];
                $customer_address = $_POST["customer_address"];
                $cash = $_POST["cash"];
                $transfer = $_POST["transfer"];
                $pos = $_POST["pos"];
                $pos_charges = $_POST["pos_charges"];
                $deposit_amount = $_POST["deposit_amount"] - $pos_charges;
                $date = date(" d-m-Y");
                $remark = "deposit";
                $status = "pending";
                $total = 0;
                $quantity = 0;
                $price = 0;
                $amount = 0;
                $balance = 0;
                $customer_type = "Deposit";
                $old_deposit = 'None';
                $staff = $_SESSION['staffname'];
                $username = $_SESSION['staffusername'];
                $invoice_no = $_POST["invoice_no"];
                $_SESSION["invoice_no_deposit"] = $invoice_no;
                $_SESSION["cash_deposit"] = $cash;
                $_SESSION["transfer_deposit"] = $transfer;
                $_SESSION["pos_deposit"] = $pos;
                $_SESSION["pos_charges_deposit"] = $pos_charges;
                $_SESSION["deposit_amount_deposit"] = $deposit_amount;
                $pos_type = $_POST["pos_type"];
                    


                if ($_POST["cash"] == 0 && $_POST["transfer"] != 0 && $_POST["pos"] == 0) {
                    $bill_type = "Transfer";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] == 0 && $_POST["pos"] == 0) {
                    $bill_type = "Cash";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] == 0 && $_POST["pos"] != 0) {
                    $bill_type = "POS";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] != 0 && $_POST["pos"] == 0) {
                    $bill_type = "Cash/Transfer";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] == 0 && $_POST["pos"] != 0) {
                    $bill_type = "Cash/POS";
                } elseif ($_POST["cash"] != 0 && $_POST["transfer"] != 0 && $_POST["pos"] != 0) {
                    $bill_type = "Cash/Transfer/POS";
                } elseif ($_POST["cash"] == 0 && $_POST["transfer"] != 0 && $_POST["pos"] != 0) {
                    $bill_type = "Transfer/POS";
                }

                $bank_name = $_POST["bank"];

                $fetch_last_invoice_no = $this->checkInvoicer();
                $get  = mysqli_fetch_array($fetch_last_invoice_no);
                $invoice_no_db = $get["invoice_no"];
                $add_invoice_no = $invoice_no_db + 1;
                $invoice_no3 = ltrim($add_invoice_no, '0');
                if (strlen($invoice_no3) == 1) {
                    $invoice_no2 =  "0000000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 2) {
                    $invoice_no2 =  "000000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 3) {
                    $invoice_no2 =  "00000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 4) {
                    $invoice_no2 =  "0000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 5) {
                    $invoice_no2 =  "000" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 6) {
                    $invoice_no2 =  "00" . $add_invoice_no;
                } elseif (strlen($invoice_no3) == 7) {
                    $invoice_no2 =  "0" . $add_invoice_no;
                } else {
                    $invoice_no2 =  $add_invoice_no;
                }
                $transport = 0;
                $fetch = $this->checkInvoice_noExist($invoice_no);
                $check_deposit = $this->showDeposit($customer_name, $customer_address);
                if (mysqli_num_rows($fetch) > 0) {
                    $this->addBank($customer_name, $customer_address, $invoice_no2, $remark, $transfer, $bank_name, $status, $staff, $date);

                    foreach ($_POST as $key => $value) {
                        if (strpos($key, 'product-name-input-') !== false) {
                            $product_name = $value;
                            $inputIndex = substr($key, -1);
                            $model_input = $_POST["model-input-$inputIndex"];
                            $manufacturer_input = $_POST["manufacturer-input-$inputIndex"];

                            $this->addSalesDetails($customer_name, $customer_address, $invoice_no2, $remark, $product_name, $model_input, $manufacturer_input, $quantity, $price, $amount, $staff, $date);
                            $this->depositAddDetails($customer_name, $customer_address, $invoice_no2, $product_name, $model_input, $manufacturer_input, $date, $staff);
                        }
                    }
                    $this->addSales($customer_name, $customer_address, $invoice_no2, $bill_type, $remark, $total, $cash, $transfer, $pos, $old_deposit, $deposit_amount, $transport, $balance, $staff, $date, $username);
                    if (mysqli_fetch_row($check_deposit) > 0){
                        $this->depositUpdate($customer_name, $customer_address,$invoice_no2, $cash, $transfer, $pos, $deposit_amount, $date, $staff);
                    }else{
                        $this->depositAdd($customer_name, $customer_address, $invoice_no2, $bill_type, $cash, $transfer, $pos, $deposit_amount, $date, $staff);
                    }
                    $this->addPos($customer_name, $customer_address, $invoice_no, $pos_type,$pos_charges);
                    echo "<script> window.location = '../print/staff/deposit.php' </script>";
                } else {
                    $this->addBank($customer_name, $customer_address, $invoice_no, $remark, $transfer, $bank_name, $status, $staff, $date);

                    foreach ($_POST as $key => $value) {
                        if (strpos($key, 'product-name-input-') !== false) {
                            $product_name = $value;
                            $inputIndex = substr($key, -1);
                            $model_input = $_POST["model-input-$inputIndex"];
                            $manufacturer_input = $_POST["manufacturer-input-$inputIndex"];

                            $this->addSalesDetails($customer_name, $customer_address, $invoice_no, $remark, $product_name, $model_input, $manufacturer_input, $quantity, $price, $amount, $staff, $date);
                            $this->depositAddDetails($customer_name, $customer_address, $invoice_no, $product_name, $model_input, $manufacturer_input, $date, $staff);
                        }
                    }
                    $this->addSales($customer_name, $customer_address, $invoice_no, $bill_type, $remark, $total, $cash, $transfer, $pos, $old_deposit, $deposit_amount, $transport, $balance, $staff, $date, $username);
                    if (mysqli_fetch_row($check_deposit) > 0){
                        $this->depositUpdate($customer_name, $customer_address,$invoice_no, $cash, $transfer, $pos, $deposit_amount, $date, $staff);
                    }else{
                        $this->depositAdd($customer_name, $customer_address, $invoice_no, $bill_type, $cash, $transfer, $pos, $deposit_amount, $date, $staff);
                    }
                    $this->addPos($customer_name, $customer_address, $invoice_no, $pos_type,$pos_charges);
                    echo "<script> window.location = '../print/staff/deposit.php' </script>";
                }
            } else {
                $this->customer_nameErr = "Please Enter Customer Name";
                $this->customer_addressErr = "Please Enter Customer Name";
            }
        }
    }
    public function viewDepositDetails()
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            return $this->showDepositDetailsEach($invoice, $customer_name, $address);
        }
    }
    public function viewDeposit($table)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            $select = $this->showDepositEach($invoice, $customer_name, $address);
            $row = mysqli_fetch_array($select);
            return $row["$table"];
        }
    }
}
?>