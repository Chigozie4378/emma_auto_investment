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
        //<============================================ USER START=================================================>//
        public function logout()
        {
            session_destroy();
            header("location:../admin_login.php");
        }

        public function loginAdmin()
        {
            if (isset($_POST["login"])) {
                $username = mysqli_escape_string($this->connect(), $_POST["username"]);
                $password = md5(mysqli_escape_string($this->connect(), $_POST["password"]));

                $admin = $this->adminLogin($username, $password);
                $result = mysqli_fetch_array($admin);

                if (mysqli_num_rows($admin) > 0) {
                    $username = $result["username"];
                    $fullname = $result['firstname'] . " " . $result['lastname'];
                    $_SESSION["adminfullname"] = $fullname;
                    $_SESSION["adminusername"] = $username;
                    header("location:admin/sales_history.php");
                } else {
                    echo "<div class='alert alert-danger text-center'>
                <strong>Danger!</strong> Invalid Login Details.
              </div>";
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
                     setTimeout(function() {
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
                } else {
                    $this->addDebits($customer_name, $address, $total, $deposit, $balance, $staff, $date);
                    $this->addIntoDebitDetails($customer_name, $address, $total, $deposit, $deposit2, $balance, $balance2, $staff, $date, $comment);
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
                $customer_address =  $_GET["address"];
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
                    $row = mysqli_fetch_array($this->showSupplyCheck($invoice, $customer_name, $address));
                    return $row["$tablename"];
                }
            }
        }
    }
    ?>