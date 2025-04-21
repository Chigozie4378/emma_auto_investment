<?php
class Controller extends Model
{
    //=========================== Drop tables ===================================//

    public function print($location)
    {
        if (isset($_POST["print"])) {
            return new Redirect($location);
        }
    }
    public function random()
    {
        $select = $this->checkInvoice();
        $row = mysqli_fetch_array($select);
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
    //<============================================ USER START=================================================>//
    public function logout()
    {
        session_destroy();
        header("location:../admin_login.php");
    }

    // public function loginAdmin()
    // {
    //     if (isset($_POST["login"])) {
    //         $username = mysqli_escape_string($this->connect(), $_POST["username"]);
    //         $password = md5(mysqli_escape_string($this->connect(), $_POST["password"]));

    //         $admin = $this->adminLogin($username, $password);
    //         $result = mysqli_fetch_array($admin);

    //         if (mysqli_num_rows($admin) > 0) {
    //             $username = $result["username"];
    //             $fullname = $result['firstname'] . " " . $result['lastname'];
    //             $_SESSION["adminfullname"] = $fullname;
    //             $_SESSION["adminusername"] = $username;
    //             header("location:admin/sales_history.php");
    //         } else {
    //             echo "<div class='alert alert-danger text-center'>
    //         <strong>Danger!</strong> Invalid Login Details.
    //       </div>";
    //         }
    //     }
    // }
    public function loginUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = mysqli_escape_string($this->connect(), $_POST["username"]);
            $password = md5(mysqli_escape_string($this->connect(), $_POST["password"]));
            $mac_address = mysqli_escape_string($this->connect(), $_POST['mac_address']);

            // Retrieve the MAC address from the form submission

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
                "8D:57:C3:0F:56:45".
                "6C:3B:E5:13:27:11",  
                "18:99:F5:82:8E:78" 
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

            // Check if the MAC address is allowed and if the current time is within office hours
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

    public function viewSalesDetailDebit()
    {
        if (isset($_GET['invoice'])) {
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            return $this->showDebitInvoice($customer_name, $address);
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

    public function addNewCustomer()
    {
        if (isset($_POST["add"])) {
            $companyname = mysqli_escape_string($this->connect(), $_POST["companyname"]);
            $company = $this->newCompany($companyname);
            $count = mysqli_num_rows($company);
            if ($count > 0) { ?>

                <script>
                    document.getElementById('danger').style.display = 'block';
                    document.getElementById('success').style.display = 'none';
                </script>
            <?php } else {
                $this->addCompany($companyname);
                ?>
                <script>
                    document.getElementById('danger').style.display = 'none';
                    document.getElementById('success').style.display = 'block';
                    setTimeout(function () {
                        window.location.href = window.location.href
                    }, 1000);
                </script>
            <?php }
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
                    setTimeout(function () {
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

    public function addingFromDebitBook()
    {
        if (isset($_POST["add"])) {
            $customer_name = $_POST["customer_name"];
            $address = $_POST["address"];
            $total = $_POST["total"];
            $deposit = $_POST["deposit"];
            $deposit2 = $_POST["deposit"];
            $balance = $_POST["balance"];
            $balance2 = $_POST["balance"];
            $staff = $_SESSION["adminfullname"];
            $date = $_POST["date"];
            $comment = $_POST["comment"];
            $show_debits = $this->showDebitHistoriesTotalPaidTotalBal($customer_name, $address);
            $row = mysqli_fetch_array($show_debits);
            $dbtotal_deposit = $row["total_paid"];
            $dbtotal_bal = $row["total_balance"];
            $total_deposit = $dbtotal_deposit + $deposit;
            $total_bal = $dbtotal_bal + $balance;
            $select1 = $this->chechDebitDetails($customer_name, $address);
            if (mysqli_num_rows($select1) > 0) {
                $this->updateFromDebitBook($total, $deposit, $balance, $customer_name, $address);
                $this->addIntoDebitDetails($customer_name, $address, $total, $deposit, $total_deposit, $balance, $total_bal, $staff, $date, $comment);
                $this->deleteDebit();
            } else {
                $this->addDebits($customer_name, $address, $total, $deposit, $balance, $staff, $date);
                $this->addIntoDebitDetails($customer_name, $address, $total, $deposit, $deposit2, $balance, $balance2, $staff, $date, $comment);
                $this->deleteDebit();
            }
            Session::unset("customer_name");
            Session::unset("address");
            Session::unset("total");
            Session::unset("deposit");
            Session::unset("balance");
            Session::unset("date");
            Session::unset("customer_name");
            echo "<script>
            window.location = 'debit_book.php'
            </script>";
        }
    }
    public function CheckRecord()
    {
        if (isset($_POST["check"])) {
            $customer_name = $_POST["customer_name"];
            $address = $_POST["address"];
            $total = $_POST["total"];
            $deposit = $_POST["deposit"];
            $balance = $_POST["balance"];
            $date = date('d-m-Y', strtotime($_POST["date"]));
            $comment = $_POST["comment"];
            Session::Name("customer_name", $customer_name);
            Session::Name("address", $address);
            Session::Name("total", $total);
            Session::Name("deposit", $deposit);
            Session::Name("balance", $balance);
            Session::Name("date", $date);
        }
    }
    public function viewDebit()
    {
        if (isset($_GET["customer_name"]) && $_GET["address"]) {
            $customer_name = $_GET["customer_name"];
            $customer_address = $_GET["address"];
            $select = $this->debitView($customer_name, $customer_address);
            return $select;
        }
    }
    public function confirmTransfer()
    {
        if (isset($_GET["invoice_no"])) {
            $invoice_no = $_GET["invoice_no"];
            $bank_name = $_GET["bank_name"];
            $this->updateSalesBank($invoice_no, $bank_name);
            $this->deleteTransfer($invoice_no);
            // new Redirect("confirm_transfer.php");

        }
    }
    public function supplyCheck($tablename)
    {
        if (isset($_GET['invoice'])) {
            $invoice = $_GET['invoice'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice']) {
                $row = mysqli_fetch_assoc($this->showSupplyCheck($invoice, $customer_name, $address));
                return $row["$tablename"];
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
    public function debitUpdate1()
    {
        if (isset($_POST["update"])) {
            $id = $_POST["id"];
            $customer_name = $_POST["customer_name"];
            $address = $_POST["address"];
            $total = $_POST["total"];
            $date = $_POST["date"];
            ;
            $deposit = $_POST["deposit"];
            $balance = $_POST["balance"];
            $staff = $_SESSION["directorfullname"];
            $this->updateDebitHistories1($customer_name, $address, $total, $deposit, $balance, $staff, $date, $id);

            echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'settle_debit.php'
                     }, 300);
            </script>";
        }
    }
    public function debitUpdate()
    {
        if (isset($_POST["update"])) {
            $id = $_POST["id"];
            $customer_name = $_POST["customer_name"];
            $customer_address = $_POST["address"];
            $date = $_POST["date"];
            ;
            $deposit = $_POST["deposit"];
            $balance = $_POST["balance"];
            $total = 0;
            $pay = $_POST["pay"];
            $comment = $_POST["comment"];
            $total_paid = $deposit + $pay;
            $new_balance = $balance - $pay;
            $staff = $_SESSION["adminfullname"];
            $settled = "SETTLED";
            $username = $_SESSION["adminusername"];
            $remark = "Old Balance Payment";
            $bill_type = "Cash (Old Balance)";
            Session::name("customer_name", $customer_name);
            Session::name("customer_address", $customer_address);
            Session::name("date", $date);
            Session::name("pay", $pay);
            Session::name("new_balance", $new_balance);
            $this->updateDebitHistories($settled);
            $this->updateDebitinput($id, $pay, $staff, $date);
            $this->addDebitsHistoryinput($customer_name, $customer_address, $total, $pay, $total_paid, $new_balance, $new_balance, $staff, $date, $comment);

            $this->deleteDebit();
            $invoice_no = $_POST["invoice_no"];
            Session::name("invoice_no", $invoice_no);
            if ($_POST["payment_type"] == "cash") {
                $fetch_last_invoice_no = $this->checkInvoice();
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
                Session::name("invoice_no", $invoice_no2);
                $transport = 0;
                $fetch = $this->checkInvoice_noExist($invoice_no);
                if (mysqli_num_rows($fetch) > 0) {
                    $this->addSales($customer_name, $customer_address, $invoice_no2, $bill_type, $remark, $total, $pay, "Nill", "Nill", "Nill", $pay, "Nill", $new_balance, $staff, $date, $username);
                    $this->addSalesDetails($customer_name, $customer_address, $invoice_no2, $remark, "Old Balance Payment", "Nill", "Nill", "Nill", "Nill", $pay, $staff, $date);
                } else {
                    $this->addSales($customer_name, $customer_address, $invoice_no, $bill_type, $remark, $total, $pay, "Nill", "Nill", "Nill", $pay, "Nill", $new_balance, $staff, $date, $username);
                    $this->addSalesDetails($customer_name, $customer_address, $invoice_no2, $remark, "Old Balance Payment", "Nill", "Nill", "Nill", "Nill", $pay, $staff, $date);
                }

                echo "<script>
                document.getElementById('update').style.display='block';
                setTimeout(function(){
                    window.location = '../print/admin/settle_debit.php'
                 }, 1000);
                    </script>";
            } else {
                echo "<script>
                document.getElementById('update').style.display='block';
                setTimeout(function(){
                    window.location = 'settle_debit.php'
                 }, 1000);
                    </script>";
            }
        }
    }
}
?>