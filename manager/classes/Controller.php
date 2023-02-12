 <?php
    class Controller extends Model
    {
        //=========================== Drop tables ===================================//
        public function wipeTables()
        {
            if (isset($_POST["wipe"])) {
                $this->tablesWipe();
            }
        }
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
            header("location:../manager_login.php");
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
        public function loginAdmin()
        {
            if (isset($_POST["login"])) {
                $username = mysqli_escape_string($this->connect(), $_POST["username"]);
                $password = md5(mysqli_escape_string($this->connect(), $_POST["password"]));

                $admin = $this->adminLogin($username, $password);
                $result = mysqli_fetch_array($admin);
                $username = $result["username"];
                $fullname = $result['firstname'] . " " . $result['lastname'];
                $_SESSION["managerfullname"] = $fullname;
                $_SESSION["managerusername"] = $username;
                $_SESSION["managerlastname"] = $result['lastname'];
                if (mysqli_num_rows($admin) > 0) {
                    header("location:manager/dashboard.php");
                } else {
                    echo "<div class='alert alert-danger text-center'>
                <strong>Danger!</strong> Invalid Login Details.
              </div>";
                }
            }
        }
        public function addNewUser()
        {
            if (isset($_POST["add"])) {
                $firstname = mysqli_escape_string($this->connect(), $_POST["firstname"]);
                $lastname = mysqli_escape_string($this->connect(), $_POST["lastname"]);
                $username = mysqli_escape_string($this->connect(), $_POST["username"]);
                $password = Hash::password(mysqli_escape_string($this->connect(), $_POST["password"]));
                $role = mysqli_escape_string($this->connect(), $_POST["role"]);

                $user = $this->newUser($username);
                $count = mysqli_num_rows($user);
                if ($count > 0) { ?>

                 <script>
                     document.getElementById('danger').style.display = 'block';
                     document.getElementById('success').style.display = 'none';
                 </script>
             <?php } else {
                    $this->addUser($firstname, $lastname, $username, $password, $role);
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

        public function userDelete()
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $this->deleteUser($id); ?>
                 <script>
                     document.getElementById('delete').style.display = 'block';
                 </script>
             <?php }
            }
        }
        public function userEdit($tablename)
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $row = mysqli_fetch_array($this->editUser($id));
                    echo $row["$tablename"];
                }
            }
        }
        public function userUpdate()
        {
            if (isset($_POST["edit"])) {
                $id = mysqli_escape_string($this->connect(), $_POST["id"]);
                $firstname = mysqli_escape_string($this->connect(), $_POST["firstname"]);
                $lastname = mysqli_escape_string($this->connect(), $_POST["lastname"]);
                $username = mysqli_escape_string($this->connect(), $_POST["username"]);
                $password = mysqli_escape_string($this->connect(), $_POST["password"]);
                $role = mysqli_escape_string($this->connect(), $_POST["role"]);
                $status = mysqli_escape_string($this->connect(), $_POST["status"]);

                $this->updateUser($id, $firstname, $lastname, $username, $password, $role, $status);
                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'add_new_user.php'
                     }, 2000);
            </script>";
            }
        }
        public function userBlock()
        {
            if (isset($_GET['username'])) {
                $username = $_GET['username'];
                $this->blockUser($username);

                new Redirect("add_new_user.php");
            }
        }
        public function userUnBlock()
        {
            if (isset($_GET['username1'])) {
                $username = $_GET['username1'];
                $this->unBlockUser($username);

                new Redirect("add_new_user.php");
            }
        }

        //<============================================ USER END===================================================>//

        //<============================================ UNIT START=================================================>//
        public function addNewUnit()
        {
            if (isset($_POST["add"])) {
                $unitname = mysqli_escape_string($this->connect(), $_POST["unitname"]);
                $unit = $this->newUnit($unitname);
                $count = mysqli_num_rows($unit);
                if ($count > 0) { ?>

                 <script>
                     document.getElementById('danger').style.display = 'block';
                     document.getElementById('success').style.display = 'none';
                 </script>
             <?php } else {
                    $this->addUnit($unitname);
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

        public function unitDelete()
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $this->deleteUnit($id); ?>
                 <script>
                     document.getElementById('delete').style.display = 'block';
                 </script>
             <?php }
            }
        }
        public function unitShow($tablename)
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $row = mysqli_fetch_array($this->editUnit($id));
                    echo $row["$tablename"];
                }
            }
        }
        public function unitUpdate()
        {
            if (isset($_POST["edit"])) {
                $id = mysqli_escape_string($this->connect(), $_POST["id"]);
                $unitname = mysqli_escape_string($this->connect(), $_POST["unitname"]);
                $this->updateUnit($id, $unitname);
                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'add_new_unit.php'
                     }, 2000);
            </script>";
                header("location:add_new_edit.php");
            }
        }

        //<============================================ UNIT END========================================================>//

        //<============================================ PRODUCER START =================================================>//
        public function addNewProducer()
        {
            if (isset($_POST["add"])) {
                $distributor = mysqli_escape_string($this->connect(), $_POST["distributor"]);
                $company = mysqli_escape_string($this->connect(), $_POST["company"]);
                $contact = mysqli_escape_string($this->connect(), $_POST["contact"]);
                $email = mysqli_escape_string($this->connect(), $_POST["email"]);
                $address = mysqli_escape_string($this->connect(), $_POST["address"]);
                $this->addProducer($distributor, $company, $contact, $email, $address);
                echo "<script>
                document.getElementById('success').style.display='block';
                setTimeout(function(){
                   window.location.href = window.location.href
                }, 3000);
            </script>";
            }
        }

        public function producerDelete()
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $this->deleteProducer($id); ?>
                 <script>
                     document.getElementById('delete').style.display = 'block';
                 </script>
             <?php }
            }
        }
        public function producerEdit($tablename)
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $row = mysqli_fetch_array($this->editProducer($id));
                    echo $row["$tablename"];
                }
            }
        }
        public function producerUpdate()
        {
            if (isset($_POST["edit"])) {
                $id = mysqli_escape_string($this->connect(), $_POST["id"]);
                $distributor = mysqli_escape_string($this->connect(), $_POST["distributor"]);
                $company = mysqli_escape_string($this->connect(), $_POST["company"]);
                $contact = mysqli_escape_string($this->connect(), $_POST["contact"]);
                $email = mysqli_escape_string($this->connect(), $_POST["email"]);
                $address = mysqli_escape_string($this->connect(), $_POST["address"]);


                $this->updateProducer($id, $distributor, $company, $contact, $email, $address);
                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'add_new_producer.php'
                     }, 2000);
            </script>";
            }
        }

        //<============================================ PRODUCER END ==================================================>//

        //<============================================ COMPANY START =================================================>//
        public function addNewCompany()
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

        public function companyDelete()
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $this->deleteCompany($id); ?>
                 <script>
                     document.getElementById('delete').style.display = 'block';
                 </script>
             <?php }
            }
        }
        public function companyShow($tablename)
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $row = mysqli_fetch_array($this->editCompany($id));
                    echo $row["$tablename"];
                }
            }
        }
        public function companyUpdate()
        {
            if (isset($_POST["edit"])) {
                $id = mysqli_escape_string($this->connect(), $_POST["id"]);
                $companyname = mysqli_escape_string($this->connect(), $_POST["companyname"]);
                $this->updateCompany($id, $companyname);
                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'add_new_company.php'
                     }, 2000);
            </script>";
                header("location:add_new_edit.php");
            }
        }

        //<============================================ COMPANY END ===================================================>//


        //<============================================ PRODUCT START =================================================>//
        public function addNewProduct()
        {
            if (isset($_POST["add"])) {
                $name = mysqli_escape_string($this->connect(), $_POST["name"]);
                $model = mysqli_escape_string($this->connect(), $_POST["model"]);
                $manufacturer = mysqli_escape_string($this->connect(), $_POST["manufacturer"]);
                $quantity = mysqli_escape_string($this->connect(), $_POST["quantity"]);
                $cprice = mysqli_escape_string($this->connect(), $_POST["c_price"]);
                $wprice = mysqli_escape_string($this->connect(), $_POST["w_price"]);
                $rprice = mysqli_escape_string($this->connect(), $_POST["r_price"]);

                $Product = $this->newProduct($name, $model, $manufacturer);
                $count = mysqli_num_rows($Product);
                if ($count > 0) { ?>

                 <script>
                     document.getElementById('danger').style.display = 'block';
                     document.getElementById('success').style.display = 'none';
                 </script>
             <?php } else {
                    $this->addProduct($name, $manufacturer, $model, $quantity, $cprice, $wprice, $rprice);
                ?>
                 <script>
                     document.getElementById('danger').style.display = 'none';
                     document.getElementById('success').style.display = 'block';
                     // setTimeout(function(){
                     //    window.location.href = window.location.href
                     // }, 3000);
                 </script>
             <?php }
            }
        }
        public function addproductByExcel()
        {

            if (isset($_POST["upload"])) {
                if ($_FILES["excel"]["name"]) {
                    $filename = explode(".", $_FILES["excel"]["name"]);
                    if (end($filename) == "csv") {
                        $handle = fopen($_FILES["excel"]["tmp_name"], "r");
                        $row = 1;
                        while ($data = fgetcsv($handle)) {
                            if ($row == 1) {
                                $row++;
                                continue;
                            }
                            $name = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[0])));
                            $manufacturer = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[1])));
                            $model = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[2])));
                            $qty = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[3])));
                            $cprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[4])));
                            $wprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[5])));
                            $rprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[6])));

                            $Product = $this->newProduct($name, $model, $manufacturer);
                            $count = mysqli_num_rows($Product);
                            if ($count > 0) {
                                echo $message = "Product Already Exist";
                            } else {
                                ini_set('max_execution_time', 5000);
                                ini_set('max_input_time', 5000);
                                ini_set('upload_max_filesize', '100M');
                                ini_set('post_max_size', '100M');
                                ini_set('memory_limit', '3560M');
                                $this->addExcelproduct($name, $manufacturer, $model, $qty, $cprice, $wprice, $rprice);

                                header("location:stock.php");
                            }
                        }
                        fclose($handle);
                    } else {
                        echo $message = "Please Select a CSV File";
                    }
                } else {
                    echo $message = "Please Select a File";
                }
            }
        }
        public function updateExcelQty()
        {

            if (isset($_POST["upload"])) {
                if ($_FILES["excel"]["name"]) {
                    $filename = explode(".", $_FILES["excel"]["name"]);
                    if (end($filename) == "csv") {
                        $handle = fopen($_FILES["excel"]["tmp_name"], "r");
                        $row = 1;
                        while ($data = fgetcsv($handle)) {
                            if ($row == 1) {
                                $row++;
                                continue;
                            }
                            $name = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[0])));
                            $manufacturer = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[1])));
                            $model = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[2])));
                            $qty = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[3])));
                            $cprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[4])));
                            $wprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[5])));
                            $rprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[6])));
                            ini_set('max_execution_time', 5000);
                            ini_set('max_input_time', 5000);
                            ini_set('upload_max_filesize', '100M');
                            ini_set('post_max_size', '100M');
                            ini_set('memory_limit', '3560M');
                            $this->addQtyExcel($name, $manufacturer, $model, $qty);

                            header("location:stock.php");
                        }
                        fclose($handle);
                    } else {
                        echo $message = "Please Select a CSV File";
                    }
                } else {
                    echo $message = "Please Select a File";
                }
            }
        }
        public function updateExcelPrice()
        {

            if (isset($_POST["upload"])) {
                if ($_FILES["excel"]["name"]) {
                    $filename = explode(".", $_FILES["excel"]["name"]);
                    if (end($filename) == "csv") {
                        $handle = fopen($_FILES["excel"]["tmp_name"], "r");
                        $row = 1;
                        while ($data = fgetcsv($handle)) {
                            if ($row == 1) {
                                $row++;
                                continue;
                            }
                            $name = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[0])));
                            $manufacturer = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[1])));
                            $model = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[2])));
                            $qty = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[3])));
                            $cprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[4])));
                            $wprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[5])));
                            $rprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[6])));

                            ini_set('max_execution_time', 5000);
                            ini_set('max_input_time', 5000);
                            ini_set('upload_max_filesize', '100M');
                            ini_set('post_max_size', '100M');
                            ini_set('memory_limit', '3560M');

                            $this->updatePriceExcel($name, $manufacturer, $model, $cprice, $wprice, $rprice);

                            header("location:stock.php");
                        }
                        fclose($handle);
                    } else {
                        echo $message = "Please Select a CSV File";
                    }
                } else {
                    echo $message = "Please Select a File";
                }
            }
        }
        public function ProductDelete()
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $this->deleteProduct($id); ?>
                 <script>
                     document.getElementById('delete').style.display = 'block';
                 </script>
             <?php }
            }
        }
        public function ProductEdit($tablename)
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_GET['id']) {
                    $row = mysqli_fetch_array($this->editProduct($id));
                    echo $row["$tablename"];
                }
            }
        }
        public function ProductUpdate()
        {
            if (isset($_POST["edit"])) {
                $id = mysqli_escape_string($this->connect(), $_POST["id"]);
                $name = mysqli_escape_string($this->connect(), $_POST["name"]);
                $model = mysqli_escape_string($this->connect(), $_POST["model"]);
                $manufacturer = mysqli_escape_string($this->connect(), $_POST["manufacturer"]);
                $new_quantity = $_POST["quantity"];
                $old_quantity = $_POST["quantity1"];
                $quantity = $old_quantity + $new_quantity;
                $cprice = mysqli_escape_string($this->connect(), $_POST["cprice"]);
                $wprice = mysqli_escape_string($this->connect(), $_POST["wprice"]);
                $rprice = mysqli_escape_string($this->connect(), $_POST["rprice"]);

                $this->updateProduct($id, $name, $model, $manufacturer, $quantity, $cprice, $wprice, $rprice);
                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'stock.php'
                    }, 500);
            </script>";
            }
        }
        //<=========================================================== PRODUCT END ============================================================>//

        //<============================================ FUNCTION TO GENERATE INVOICE NO START =================================================>//
        public function random()
        {
            $select = $this->checkInvoice();
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

        //<=============================================================== SALES ============================================================>//
        public function sales()
        {
            if (isset($_POST["generate_bill"])) {
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
                $invoice_no = $_POST["invoice_no"];

                $_SESSION["invoice"] = $invoice_no;
                $_SESSION["customer_name"] = $customer_name;
                $_SESSION["address"] = $address;
                $date = $_POST["date"];
                $cash = $_POST["cash"];
                $transfer = $_POST["transfer"];
                $pos = $_POST["pos"];
                $deposit = $_POST["deposit"];
                $balance = $_POST["balance"];
                $total = $_POST["tot"];
                $staff = $_SESSION["managerfullname"];
                $username = $_SESSION["managerusername"];
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
                $status = "pending";
                $comment = "New Goods Bought";

                $fetch_last_invoice_no = $this->checkInvoice();
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

                $fetch = $this->checkInvoice_noExist($invoice_no);
                if (!($err)) {
                    if (mysqli_num_rows($fetch) > 0) {
                        if (!(empty($_POST["bank"]))) {
                            $bank_name = $_POST["bank"];
                            $this->addBank($customer_name, $address, $invoice_no2, $customer_type, $transfer, $bank_name, $status, $staff, $date);
                        }
                        $this->addSales($customer_name, $address, $invoice_no2, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $deposit, $balance, $staff, $date, $username);
                        $row = mysqli_num_rows($this->checkDebit($customer_name, $address));
                        $history = mysqli_fetch_array($this->checkDebitHistories($customer_name, $address));
                        $balancedb = $history["total_balance"];
                        $depositdb = $history["deposit"];
                        $prev_total_paid = $history["total_paid"];
                        $total_paid = $deposit + $prev_total_paid;
                        $new_balance = $balance + $balancedb;
                        if ($balance != 0) {
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
                                    $amount = (int)$quantity_session * (int)$price_session;
                                    $qty = (int)($quantity_session);
                                    //

                                    $this->addSalesDetails($customer_name, $address, $invoice_no2, $customer_type, $productname_session, $model_session, $manufacturer_session, $quantity_session, $price_session, $amount, $staff, $date);
                                    $this->updateQty($qty, $productname_session, $model_session, $manufacturer_session);
                                }
                            }
                        }
                        if ($_POST["customer_type"] == "retail") {
                            Session::unset("cart");
                            echo "<script> window.location = '../print/director/retail_print.php' </script>";
                        } else {
                            Session::unset("cart");
                            echo "<script> window.location = 'print_receipt_w.php' </script>";
                        }
                    } else {
                        if (!(empty($_POST["bank"]))) {
                            $bank_name = $_POST["bank"];
                            $this->addBank($customer_name, $address, $invoice_no, $customer_type, $transfer, $bank_name, $status, $staff, $date);
                        }
                        $this->addSales($customer_name, $address, $invoice_no, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $deposit, $balance, $staff, $date, $username);
                        $row = mysqli_num_rows($this->checkDebit($customer_name, $address));
                        $history = mysqli_fetch_array($this->checkDebitHistories($customer_name, $address));
                        $balancedb = $history["total_balance"];
                        $depositdb = $history["deposit"];
                        $prev_total_paid = $history["total_paid"];
                        $total_paid = $deposit + $prev_total_paid;
                        $new_balance = $balance + $balancedb;
                        if ($balance != 0) {
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
                                    $amount = (int)$quantity_session * (int)$price_session;
                                    $qty = (int)($quantity_session);
                                    //

                                    $this->addSalesDetails($customer_name, $address, $invoice_no, $customer_type, $productname_session, $model_session, $manufacturer_session, $quantity_session, $price_session, $amount, $staff, $date);
                                    $this->updateQty($qty, $productname_session, $model_session, $manufacturer_session);
                                }
                            }
                        }
                        if ($_POST["customer_type"] == "retail") {
                            Session::unset("cart");
                            echo "<script> window.location = '../print/manager/retail_print.php' </script>";
                        } else {
                            Session::unset("cart");
                            echo "<script> window.location = 'print_receipt_w.php' </script>";
                        }
                    }
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

        public function viewSalesDetailDebit()
        {
            if (isset($_GET['invoice'])) {
                $customer_name = $_GET['customer_name'];
                $address = $_GET['address'];
                return $this->showDebitInvoice($customer_name, $address);
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
                $date = date("d-m-Y");
                $staff = $_SESSION['managerfullname'];
                // $new_deposit = $total + $deposit;
                // $new_balance = $balance - $total;
                // $new_balance1 = $balance - $total;
                $debit_total = 0;

                $show_debits = $this->showDebitTotalPaidTotalBal($customer_name, $address);
                $row = mysqli_fetch_array($show_debits);
                $dbtotal_deposit = $row["deposit"];
                $dbtotal_bal = $row["balance"];
                $total_deposit = $dbtotal_deposit + $total;
                $total_bal1 = $dbtotal_bal - $total;
                $total_bal2 = $dbtotal_bal - $total;


                if (mysqli_num_rows($show_debits) > 0) {

                    $comment = "All Goods Returned for " . $customer_name . " " . $address;
                    $this->insertAllReturn($customer_name, $address, $invoice_no, $payment_type, $total, $cash, $transfer, $deposit, $balance, $staff, $date);
                    $this->updateReturnDebits($total_deposit, $total_bal1, $customer_name, $address);
                    $this->insertReturnDebitsDetails($customer_name, $address, $debit_total, $total, $total_deposit, $total_bal1, $total_bal2, $staff, $date, $comment);
                    $this->deleteDebit();
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

                        $this->insertAllReturnDetails($customer_name1, $address1, $invoice_no1, $productname, $model, $manufacturer, $quantity, $price, $amount, $staff, $date1);
                        $this->updateReturnGoodsQty($quantity, $productname, $model, $manufacturer);
                        $this->deletesalesDetails($invoice);
                    }
                    header("location:sales_history.php");
                } else {
                    $this->insertAllReturn($customer_name, $address, $invoice_no, $payment_type, $total, $cash, $transfer, $deposit, $balance, $staff, $date);
                    $this->deleteDebit();
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

                        $this->insertAllReturnDetails($customer_name1, $address1, $invoice_no1, $productname, $model, $manufacturer, $quantity, $price, $amount, $staff, $date1);
                        $this->updateReturnGoodsQty($quantity, $productname, $model, $manufacturer);
                        $this->deletesalesDetails($invoice);
                    }
                    header("location:sales_history.php");
                }
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
                    $row = mysqli_fetch_array($this->showEachReturn($invoice));
                    echo $row["$tablename"];
                }
            }
        }
        public function viewReturnTotal()
        {
            if (isset($_GET['invoice'])) {
                $invoice = $_GET['invoice'];
                return $this->showReturnTotal($invoice);
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
                $total = 0;
                $pay = $_POST["pay"];
                $comment = $_POST["comment"];
                $total_paid = $deposit + $pay;
                $new_balance = $balance - $pay;
                $staff = $_SESSION["managerfullname"];
                $settled = "SETTLED";
                $this->updateDebitHistories($settled);
                $this->updateDebitinput($id, $pay, $staff, $date);
                $this->addDebitsHistoryinput($customer_name, $address, $total, $pay, $total_paid, $new_balance, $new_balance, $staff, $date, $comment);
                $this->updateDebitHistories($settled);
                $this->deleteDebit();
                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'settle_debit.php'
                     }, 300);
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
                $staff = $_SESSION["managerfullname"];
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
    }
    ?>