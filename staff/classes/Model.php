<?php
class Model extends DB
{



    //<============================================ USER START=================================================>//
    // protected function userLogin($username, $password)
    // {
    //     $dbconn = $this->connect();
    //     $query = "SELECT * FROM registered WHERE username = ? AND role=? AND status= ? AND password = ? ";
    //     $stmt = $dbconn->prepare($query);
    //     $stmt->bind_param("ssss", $username, $role, $status, $password);
    //     $role = "staff";
    //     $status = "active";
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     // $select = mysqli_query($this->connect(),"SELECT * FROM registered WHERE username = '$username' 
    //     // AND password = '$password' AND role='user' AND status= 'active'");
    //     $row = $result->fetch_assoc();

    //     if ($result->num_rows > 0) {
    //         $username = $row["username"];
    //         $fullname = $row['firstname'] . " " . $row['lastname'];
    //         $_SESSION["staffname"] = $fullname;
    //         $_SESSION["staffusername"] = $username;
    //         $_SESSION["stafflastname"] = $row['lastname'];
    //         header("location:staff/dashboard.php");
    //     } else {
    //         echo "<div class='alert alert-danger text-center'>
    //             <strong>Danger!</strong> Invalid Login Details.
    //           </div>";
    //     }
    // }
    protected function userLogin($username, $password)
    {
        $dbconn = $this->connect();
        $query = "SELECT * FROM registered WHERE username = ? AND role=? AND status= ? AND password = ? ";
        $stmt = $dbconn->prepare($query);
        $stmt->bind_param("ssss", $username, $role, $status, $password);
        $role = "staff";
        $status = "active";
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            // Check if the user is a staff member and the status is active
            $username = $row["username"];
            $fullname = $row['firstname'] . " " . $row['lastname'];
            $_SESSION["staffname"] = $fullname;
            $_SESSION["staffusername"] = $username;
            $_SESSION["stafflastname"] = $row['lastname'];

            // Perform MAC address verification
        //     $mac_id = "50-C2-E8-EA-27-E5, 88-A4-C2-FB-F8-04, 88-A4-C2-FB-F8-03";
        //     $macAddress = IP::getMacAddress();
        //     if ($mac_id == $macAddress) {

        //         header("location: staff/dashboard.php");
        //         exit;
        //     } else {
        //         echo "<div class='alert alert-danger text-center'>
        //     <strong>Danger!</strong> You can only login with a company computer.
        //   </div>";
        //     }
        header("location: staff/dashboard.php");
        } else {
            // Invalid login details
            echo "<div class='alert alert-danger text-center'>
            <strong>Danger!</strong> Invalid Login Details.
          </div>";
        }
    }

    public function displayPassport()
    {
        $username = $_SESSION["staffusername"];
        $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE username = '$username'");
        $result = mysqli_fetch_array($select);
        echo $result["passport"];
    }

    //<============================================ USER END===================================================>//
    //<============================================ PRODUCT START =================================================>//
    public function newProduct($name, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$name' AND model = '$model' AND manufacturer = '$manufacturer'");
        return $select;
    }
    public function addProduct($name, $model, $manufacturer, $quantity, $cprice, $wprice, $rprice)
    {
        mysqli_query($this->connect(), "INSERT INTO product VALUE(null,'$name','$model','$manufacturer','$quantity','$cprice','$wprice','$rprice')");
    }
    public function showProduct()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product ORDER BY manufacturer ");
        return $select;
    }
    public function showProductInput()
    {
        $select = mysqli_query($this->connect(), "SELECT name FROM product GROUP BY name ");
        return $select;
    }
    public function showAddProduct()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product ORDER BY name DESC LIMIT 10");
        return $select;
    }
    public function deleteProduct($id)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM product WHERE id =$id");
        return $delete;
    }
    public function editProduct($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE id =$id");
        return $select;
    }
    public function updateProduct($id, $name, $model, $manufacturer, $quantity, $price)
    {
        $update = mysqli_query($this->connect(), "UPDATE product SET name='$name',model='$model',manufacturer='$manufacturer',quantity='$quantity',price='$price' WHERE id = $id");
        return $update;
    }

    //<============================================ PRODUCT END =================================================>//



    //<======================================== AJAX LOADING PRODUCT  START======================================>//
    public function productNameProduct($productname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%' GROUP BY name");
        return $select;
    }
    public function modelProduct($productname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%' GROUP BY model");
        return $select;
    }
    public function manufacturerProduct($productname, $model)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%' AND model LIKE '%$model%' GROUP BY manufacturer");
        return $select;
    }
    public function priceProduct($productname, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$productname' AND model = '$model' AND manufacturer = '$manufacturer'");
        return $select;
    }

    public function selectStock($stock)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$stock%' OR model LIKE '%$stock%' OR manufacturer LIKE '%$stock%' OR quantity LIKE '%$stock%' OR cprice LIKE '%$stock%' OR wprice LIKE '%$stock%'OR rprice LIKE '%$stock%'");
        return $select;
    }
    public function selectNameSales($customer_name, $username)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE username = '$username' AND date LIKE '%$date%' AND customer_name LIKE '%$customer_name%'");
        return $select;
    }
    public function selectAddressSales($name, $address, $username)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' AND username = '$username' AND date LIKE '%$date%' ");
        return $select;
    }

    public function selectDebit($debit)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name LIKE '%$debit%' OR address LIKE '%$debit%' OR invoice_no LIKE '%$debit%' OR date LIKE '%$debit%'");
        return $select;
    }
    public function selectDebitName($name)
    {

        $select = mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name LIKE '%$name%'");
        return $select;
    }
    public function selectDebitAddress($name, $address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' ");
        return $select;
    }
    public function selectDebitDate($name, $address, $date)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' AND date LIKE '%$date%'");
        return $select;
    }

    public function selectDebitHistoryName($name)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name LIKE '%$name%'");
        return $select;
    }
    public function selectDebitHistoryAddress($name, $address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' ");
        return $select;
    }
    public function selectDebitHistoryDate($name, $address, $date)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' AND date LIKE '%$date%'");
        return $select;
    }
    public function quantityProduct($productname, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$productname' AND model = '$model' AND manufacturer = '$manufacturer'");
        return $select;
    }
    //<======================================== AJAX LOADING PRODUCT  END========================================>//

    //<============================================ SALES START =================================================>//
    // public function newsales($salesname){
    //     $select = mysqli_query($this->connect(),"SELECT * FROM sales WHERE salesname = '$salesname'");
    //     return $select;
    // }
    public function checkInvoice($page)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales ORDER BY id DESC LIMIT 1 WHERE invoice_no ='$page'");
        return $select;
    }
    // public function checkInvoice($page){
    //     $select = mysqli_query($this->connect(),"SELECT * FROM sales ORDER BY id DESC LIMIT 1 WHERE invoice_no ='$page'");
    //     return $select;
    // }
    public function invoiceLock()
    {
        mysqli_query($this->connect(), "SELECT * FROM sales FOR UPDATE");
    }
    public function unlockInvoice()
    {
        // release the lock on the sales table
        mysqli_query($this->connect(), "UNLOCK TABLES");
    }
    public function addBank($customer_name, $address, $invoice_no, $customer_type, $transfer, $bank_name, $status, $staff, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO bank VALUES(null,'$customer_name', '$address', '$invoice_no','$customer_type','$transfer','$bank_name', '$status','$staff', '$date')");
    }
    public function addSales($customer_name, $address, $invoice_no, $bill_type, $customer_type, $total, $cash, $transfer, $pos, $old_deposit, $deposit, $transport, $balance, $staff, $date, $username)
    {
        mysqli_query($this->connect(), "INSERT INTO sales VALUES(null,'$customer_name', '$address', '$invoice_no', '$bill_type','$customer_type', '$total','$cash','$transfer','$pos','$old_deposit','$deposit', '$transport', '$balance','$staff', '$date', '$username','')");
    }
    public function addPos($customer_name, $address, $invoice_no2, $pos_type, $pos_charges)
    {
        mysqli_query($this->connect(), "INSERT INTO pos VALUES(null,'$customer_name', '$address', '$invoice_no2', '$pos_type','$pos_charges')");
    }
    public function addSalesDetails($customer_name, $address, $invoice_no, $customer_type, $productname_session, $model_session, $manufacturer_session, $quantity_session, $price_session, $amount, $staff, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO sales_details(customer_name,address,invoice_no,customer_type,product_name,model,manufacturer,quantity,price,amount,staff_name,date) VALUES('$customer_name', '$address', '$invoice_no','$customer_type', '$productname_session', '$model_session','$manufacturer_session', '$quantity_session',  '$price_session','$amount','$staff','$date')");
    }
    public function showSalesHistory($id)
    {
        // $select = mysqli_query($this->connect(),"SELECT sales.invoice_no, sales.customer_name,sales.address,sales.payment_type,sales.total,sales.deposit,sales.balance,sales.date,
        // sales_details.product_name,sales_details.model,sales_details.manufacturer,sales_details.quantity,sales_details.price,sales_details.amount 
        // FROM sales INNER JOIN sales_details ON sales.invoice_no=sales_details.invoice_no WHERE id = $id");
        // return $select;

    }
    public function showInvoiceSales1($invoice, $customer_name, $address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE invoice_no ='$invoice' AND customer_name = '$customer_name' AND address='$address'");
        return $select;
    }
    public function showInvoiceSalesDetails1($invoice, $customer_name, $address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales_details WHERE invoice_no = '$invoice' AND customer_name = '$customer_name' AND address='$address'");
        return $select;
    }
    public function showPos($customer_name, $address, $invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM pos WHERE customer_name = '$customer_name' AND customer_address='$address' AND invoice_no = '$invoice'");
        return $select;
    }
    public function showPosInvoice($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM pos WHERE invoice_no = '$invoice'");
        return $select;
    }
    public function showInvoiceSales($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE invoice_no ='$invoice'");
        return $select;
    }
    public function showDebitInvoice($customer_name, $address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name = '$customer_name' AND address='$address'");
    }

    public function showInvoiceSalesDetails($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales_details WHERE invoice_no = '$invoice'");
        return $select;
    }
    public function showSalesCustomerName()
    {
        $select = mysqli_query($this->connect(), "SELECT DISTINCT customer_name  FROM sales");
        return $select;
    }
    public function showSalesCustomerAddress()
    {
        $select = mysqli_query($this->connect(), "SELECT DISTINCT address  FROM sales");
        return $select;
    }
    public function showInvoice()
    {
        $staff = $_SESSION["staffname"];
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE staff_name = '$staff' AND date LIKE '%$date%' ORDER BY id DESC");
        return $select;
    }
    public function showDashboardSales()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE  date Like '%$date%' AND staff_name = '" . $_SESSION['staffname'] . "'  ORDER BY id DESC LIMIT 50");
        return $select;
    }
    public function showDashboardTotal()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(total) sumTotal FROM sales WHERE date LIKE '%$date%' AND  staff_name = '" . $_SESSION['staffname'] . "'");
        return $select;
    }
    public function countDashboardCustomer()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT count(customer_name) as countcustomers FROM sales  WHERE  date LIKE '%$date%' AND  staff_name = '" . $_SESSION['staffname'] . "'");
        return $select;
    }
    public function showDashboardCredit()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(deposit) as credit FROM sales  WHERE  date LIKE '%$date%' AND staff_name = '" . $_SESSION['staffname'] . "'  ");
        return $select;
    }
    public function showDashboardCash()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(cash) as cash FROM sales  WHERE  date LIKE '%$date%' AND staff_name = '" . $_SESSION['staffname'] . "'  ");
        return $select;
    }
    public function showDashboardTransfer()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(transfer) as transfer FROM sales  WHERE  date LIKE '%$date%' AND staff_name = '" . $_SESSION['staffname'] . "'  ");
        return $select;
    }
    public function showDashboardPos()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(pos) as pos FROM sales  WHERE  date LIKE '%$date%' AND staff_name = '" . $_SESSION['staffname'] . "'  ");
        return $select;
    }
    public function showDashboardDebit()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(balance) as balance FROM sales  WHERE  date LIKE '%$date%' AND staff_name = '" . $_SESSION['staffname'] . "'  ");
        return $select;
    }


    public function updateQty($qty, $productname_session, $model_session, $manufacturer_session)
    {
        $update = mysqli_query($this->connect(), "UPDATE product SET quantity = quantity - $qty WHERE name = '$productname_session' AND model='$model_session' AND manufacturer = '$manufacturer_session'");
        return $update;
    }

    //============================Return Goods Start=======================================================
    public function insertAllReturn($customer_name, $address, $invoice_no, $payment_type, $total, $cash, $transfer, $deposit, $balance, $staff_name, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO return_goods VALUES(null,'$customer_name', '$address', '$invoice_no', '$payment_type', '$total','$cash','$transfer','$deposit', '$balance','$staff_name',  '$date')");
    }

    public function insertAllReturnDetails($customer_name1, $address1, $invoice_no1, $productname, $model, $manufacturer, $quantity, $price, $amount, $date1)
    {
        mysqli_query($this->connect(), "INSERT INTO return_goods_details VALUES(null,'$customer_name1', '$address1', '$invoice_no1', '$productname', '$model','$manufacturer', '$quantity',  '$price','$amount','$date1')");
    }
    public function showReturn()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods ");
        return $select;
    }

    public function showInvoiceReturn($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods WHERE invoice_no ='$invoice'");
        return $select;
    }

    public function showInvoiceReturnDetails($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods_details WHERE invoice_no = '$invoice'");
        return $select;
    }

    public function deletesales($invoice)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales WHERE invoice_no =$invoice");
        return $delete;
    }
    public function deletesale()
    {
        mysqli_query($this->connect(), "DELETE FROM sale WHERE total = 0");
    }
    public function deletesalesDetails($invoice)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales_details WHERE invoice_no =$invoice");
        return $delete;
    }
    public function updatesale($invoice_no, $amount)
    {
        $update = mysqli_query($this->connect(), "UPDATE sales SET total = total + $amount WHERE name = '$invoice_no'");
        return $update;
    }
    public function updateReturnGoodsQty($quantity, $productname, $model, $manufacturer)
    {
        $update = mysqli_query($this->connect(), "UPDATE product SET quantity = quantity + $quantity WHERE name = '$productname' AND model='$model' AND manufacturer = '$manufacturer'");
        return $update;
    }


    //=============================================================== CUSTOMER START =========================================================//
    public function newCustomer($customer_name, $address, $phone_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM customer WHERE customer_name = '$customer_name' AND address = '$address' AND phone_no = '$phone_no'");
        return $select;
    }
    public function customerAdd($customer_name, $address, $phone_no)
    {
        mysqli_query($this->connect(), "INSERT INTO customer VALUES(null, '$customer_name','$address','$phone_no')");
    }
    public function showCustomer()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM customer ");
        return $select;
    }
    public function deleteCustomer($id)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM customer WHERE id =$id");
        return $delete;
    }
    public function editCustomer($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM customer WHERE id =$id");
        return $select;
    }
    public function updateCustomer($id, $customer_name, $address, $phone_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE customer SET customer_name='$customer_name',address='$address',phone_no='$phone_no' WHERE id = $id");
        return $update;
    }

    //================================================================ DEBIT START ==============================================================>//
    public function addDebits($customer_name, $address, $total, $deposit, $balance, $staff, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO debit VALUES(null,'$customer_name', '$address', '$total','$deposit', '$balance','$staff',  '$date')");
    }


    public function addDebitsHistory($customer_name, $address, $total, $deposit, $total_deposit, $balance, $total_balance, $staff, $date, $comment, $invoice_no)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$total','$deposit','$total_deposit', '$balance','$total_balance', '$staff', '$date','$comment','$invoice_no')");
    }
    public function addtoDebitsHistory($customer_name, $address, $total, $deposit, $total_paid, $balance, $new_balance, $staff, $date, $comment, $invoice_no)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$total','$deposit','$total_paid','$balance', '$new_balance', '$staff', '$date','$comment','$invoice_no')");
    }
    public function selectDebits($invoice_no)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit WHERE invoice_no ='$invoice_no'");
    }
    public function showDebit()
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit");
    }
    public function showDebitHistories()
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit_histories");
    }
    public function deleteDebit()
    {
        mysqli_query($this->connect(), "DELETE FROM debit WHERE balance = 0");
    }
    // public function deleteDebitHistories(){
    //     mysqli_query($this->connect(),"DELETE FROM debit_histories WHERE balance = 0");

    // }
    public function editDebit($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit WHERE id =$id");
        return $select;
    }
    public function checkDebit($customer_name, $address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name = '$customer_name' AND address = '$address'");
    }
    public function checkDebitHistories($customer_name, $address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name = '$customer_name' AND address = '$address' ORDER BY id DESC LIMIT 1");
    }
    public function updateDebit($customer_name, $address, $total, $deposit, $balance, $staff, $date)
    {
        mysqli_query($this->connect(), "UPDATE debit SET total = total + $total, deposit = deposit + $deposit, balance = balance + $balance, staff_name = '$staff', date = '$date'  WHERE customer_name='$customer_name' AND address='$address'");
    }
    public function updateDebitinput($id, $pay, $staff, $date)
    {
        mysqli_query($this->connect(), "UPDATE debit SET  deposit = deposit + $pay, balance = balance-$pay,staff_name = '$staff', date = '$date'  WHERE id = $id");
    }
    public function addDebitsHistoryinput($customer_name, $address, $total, $pay, $total_paid, $new_balance, $total_bal, $staff, $date, $comment)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$total','$pay','$total_paid', '$new_balance','$total_bal','$staff',  '$date','$comment')");
    }

    public function checkInvoicer()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales ORDER BY id DESC LIMIT 1");
        return $select;
    }
    public function checkInvoice_noExist($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE invoice_no = '$invoice_no'");
        return $select;
    }

    // Deposit Section
    public function depositAdd($customer_name, $customer_address, $invoice_no, $bill_type, $cash, $transfer, $pos, $deposit_amount, $date, $staff)
    {
        mysqli_query($this->connect(), "INSERT INTO deposit (customer_name, customer_address,invoice_no,payment_type,cash,transfer,pos, deposit_amount,date,staff) VALUES ('$customer_name', '$customer_address','$invoice_no','$bill_type','$cash','$transfer','$pos','$deposit_amount','$date','$staff')");

    }
    public function depositUpdate($customer_name, $customer_address, $invoice_no, $cash, $transfer, $pos, $deposit_amount, $date, $staff)
    {
        mysqli_query($this->connect(), "UPDATE deposit SET invoice_no = '$invoice_no', cash = cash+$cash, transfer = transfer+$transfer, pos = pos+$pos, deposit_amount = deposit_amount+$deposit_amount, date = '$date', staff = '$staff' WHERE customer_name='$customer_name' AND customer_address='$customer_address'");
    }
    public function depositAddDetails($customer_name, $customer_address, $invoice_no, $product_name, $model_input, $manufacturer_input, $date, $staff)
    {
        mysqli_query($this->connect(), "INSERT INTO deposit_details (customer_name, customer_address,invoice_no, product_name, model, manufacturer,date,staff) VALUES ('$customer_name', '$customer_address','$invoice_no','$product_name', '$model_input', '$manufacturer_input','$date','$staff')");

    }
    public function showDepositInvoice($invoice_no)
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit WHERE invoice_no = '$invoice_no'");
    }
    public function showDepositDetailsInvoice($invoice_no)
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit_details WHERE invoice_no = '$invoice_no'");
    }
    public function showAllDeposit()
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit ORDER BY id DESC");
    }

    public function showDeposit($customer_name, $customer_address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit WHERE customer_name = '$customer_name' AND customer_address = '$customer_address'");
    }
    public function showDepositDetailsEach($invoice_no, $customer_name, $customer_address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit_details WHERE invoice_no = '$invoice_no' AND customer_name = '$customer_name' AND customer_address = '$customer_address'");
    }
    public function showDepositEach($invoice_no, $customer_name, $customer_address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit WHERE invoice_no = '$invoice_no' AND customer_name = '$customer_name' AND customer_address = '$customer_address'");
    }
    public function showDepositDetails($customer_name, $customer_address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM deposit_details WHERE customer_name = '$customer_name' AND customer_address = '$customer_address'");
    }
    public function deleteDeposit($customer_name, $address)
    {
        return mysqli_query($this->connect(), "DELETE FROM deposit WHERE customer_name = '$customer_name' AND customer_address = '$address'");
    }
    public function deleteDepositDetails($customer_name, $address)
    {
        return mysqli_query($this->connect(), "DELETE FROM deposit_details WHERE customer_name = '$customer_name' AND customer_address = '$address'");
    }
    public function deleteSalesDeposit($customer_name, $address)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales WHERE customer_name = '$customer_name' AND address = '$address' AND customer_type = 'deposit'");
        return $delete;
    }
    public function deleteSalesDepositDetails($customer_name, $address)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales_details WHERE customer_name = '$customer_name' AND address = '$address' AND customer_type = 'deposit'");
        return $delete;
    }
    public function checkSupply($customer_name, $address, $invoice_no, $supplied_by, $checked_by)
    {
        mysqli_query($this->connect(), "INSERT INTO supply_check VALUES(null,'$customer_name', '$address', '$invoice_no', '$supplied_by','$checked_by')");

    }
    public function showSupplyCheck($invoice_no, $customer_name, $customer_address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM supply_check WHERE invoice_no = '$invoice_no' AND customer_name = '$customer_name' AND customer_address = '$customer_address'");
    }
    public function showUser()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM registered");
        return $select;
    }
    public function showUserSupply()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM registered where role='others'");
        return $select;
    }
    public $qty_remaining = "";

    public function checkStockQtyRem($productname, $model, $manufacturer, $quantity)
    {
        // Query to check the stock quantity for the specified product.
        $query = mysqli_query($this->connect(), "SELECT quantity FROM product WHERE name = '$productname' AND model = '$model' AND manufacturer = '$manufacturer'");

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            $stock_quantity = (int) $row['quantity'];

            if ($quantity > $stock_quantity && $stock_quantity != 0 && $stock_quantity > 0) {
                // Set error message
                $this->qty_remaining = "$stock_quantity $productname $model $manufacturer Remaining in Stock.";
                return false;
            } elseif ($quantity > $stock_quantity && $stock_quantity == 0) {
                $this->qty_remaining = "No $productname $model $manufacturer Remaining in Stock.";
                return false;
            } elseif ($quantity > $stock_quantity) {
                $this->qty_remaining = "No $productname $model $manufacturer Remaining in Stock.";
                return false;
            }
            return true; // Quantity is available
        } else {
            // Product not found in stock
            $this->qty_remaining = "$productname $model $manufacturer not found in Stock.";
            return false;
        }
    }
}
