<?php

use Mpdf\Tag\S;

class Model extends DB
{
    public $id = 0;

    // Truncate tables
    public function tablesWipe()
    {
        mysqli_query($this->connect(), "TRUNCATE TABLE debit");
        mysqli_query($this->connect(), "TRUNCATE TABLE debit_histories");
        mysqli_query($this->connect(), "TRUNCATE TABLE return_goods");
        mysqli_query($this->connect(), "TRUNCATE TABLE return_each_goods");
        mysqli_query($this->connect(), "TRUNCATE TABLE return_goods_details");
        mysqli_query($this->connect(), "TRUNCATE TABLE sales");
        mysqli_query($this->connect(), "TRUNCATE TABLE sales_details");
        mysqli_query($this->connect(), "TRUNCATE TABLE deposit");
        mysqli_query($this->connect(), "TRUNCATE TABLE deposit_details");
        mysqli_query($this->connect(), "TRUNCATE TABLE company");

        mysqli_query($this->connect(), "TRUNCATE TABLE purchase");
        mysqli_query($this->connect(), "TRUNCATE TABLE company");
        // mysqli_query($this->connect(),"TRUNCATE TABLE customer");
        mysqli_query($this->connect(), "TRUNCATE TABLE producer");
    }
    public function wipeProduct()
    {
        mysqli_query($this->connect(), "TRUNCATE TABLE product");
        
    }
    public function wipeUser()
    {
        mysqli_query($this->connect(), "TRUNCATE TABLE registered");
    }

    //<============================================ USER START=================================================>//
    // public function adminLogin($username, $password)
    // {
    //     $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE username = '$username' AND password ='$password' AND role='director' AND status= 'active'");
    //     return $select;
    // }
    protected function userLogin($username, $password)
    {
        $dbconn = $this->connect();
        $query = "SELECT * FROM registered WHERE username = ? AND role=? AND status= ? AND password = ? ";
        $stmt = $dbconn->prepare($query);
        $stmt->bind_param("ssss", $username, $role, $status, $password);
        $role = "director";
        $status = "active";
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            // Check if the user is a staff member and the status is active
            $username = $row["username"];
            $passport = $row['passport'];
            $fullname = $row['firstname'] . " " . $row['lastname'];
            $_SESSION["directorfullname"] = $fullname;
            $_SESSION["directorusername"] = $username;
            $_SESSION["directorlastname"] = $row['lastname'];
            $_SESSION["directorpassport"] =  $passport;

            // Shut down the Flask server after successful login
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/shutdown");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        header("location: director/dashboard.php");
        } else {
            // Invalid login details
            echo "<div class='alert alert-danger text-center'>
            <strong>Danger!</strong> Invalid Login Details.
          </div>";
        }
    }



    public function newUser($username)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE username = '$username'");
        return $select;
    }
    public function addUser($firstname, $lastname, $username, $password, $role, $file_path)
    {
        mysqli_query($this->connect(), "INSERT INTO registered(firstname,lastname,username,password,role,passport,status) VALUE('$firstname','$lastname','$username','$password','$role','$file_path','active')");
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
    public function showUserBlock($username)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE username = '$username' AND status = 'inactive'");
        return $select;
    }
    public function displayPassport()
    {
        $username = $_SESSION["directorusername"];
        $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE username = '$username'");
        $result = mysqli_fetch_array($select);
        echo $result["passport"];
    }
    public function showUserUnBlock($username)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE username = '$username' AND status = 'active'");
        return $select;
    }
    public function deleteUser($id)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM registered WHERE id =$id");
        return $delete;
    }
    public function editUser($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM registered WHERE id =$id");
        return $select;
    }
    public function updateUser($id, $firstname, $lastname, $username, $password, $role, $status)
    {
        $update = mysqli_query($this->connect(), "UPDATE registered SET firstname='$firstname',lastname='$lastname',username='$username',password='$password',role='$role',status='$status' WHERE id = $id");
        return $update;
    }
    public function updateUser2($id, $firstname, $lastname, $username, $file_path, $role, $status)
    {
        $update = mysqli_query($this->connect(), "UPDATE registered SET firstname='$firstname',lastname='$lastname',username='$username',passport='$file_path',role='$role',status='$status' WHERE id = $id");
        return $update;
    }
    public function updateUser3($id, $firstname, $lastname, $username, $password, $file_path, $role, $status)
    {
        $update = mysqli_query($this->connect(), "UPDATE registered SET firstname='$firstname',lastname='$lastname',username='$username',password='$password',passport='$file_path',role='$role',status='$status' WHERE id = $id");
        return $update;
    }
    public function updateUser1($id, $firstname, $lastname, $username, $role, $status)
    {
        $update = mysqli_query($this->connect(), "UPDATE registered SET firstname='$firstname',lastname='$lastname',username='$username',role='$role',status='$status' WHERE id = $id");
        return $update;
    }
    public function blockUser($username)
    {
        $update = mysqli_query($this->connect(), "UPDATE registered SET status='inactive' WHERE username = '$username'");
        return $update;
    }
    public function unBlockUser($username)
    {
        $update = mysqli_query($this->connect(), "UPDATE registered SET status='active' WHERE username = '$username'");
        return $update;
    }
    //<============================================ USER END===================================================>//

    //<============================================ UNIT START=================================================>//
    public function newUnit($unitname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM unit WHERE unitname = '$unitname'");
        return $select;
    }
    public function addUnit($unitname)
    {
        mysqli_query($this->connect(), "INSERT INTO unit(unitname) VALUE('$unitname')");
    }
    public function showUnit()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM unit");
        return $select;
    }
    public function deleteUnit($id)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM unit WHERE id =$id");
        return $delete;
    }
    public function editUnit($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM unit WHERE id =$id");
        return $select;
    }
    public function updateUnit($id, $unitname)
    {
        $update = mysqli_query($this->connect(), "UPDATE unit SET unitname='$unitname' WHERE id = $id");
        return $update;
    }
    //<============================================ UNIT END=========-==============================================>//

    //<============================================ PRODUCER START =================================================>//

    public function addProducer($distributor, $company, $contact, $email, $address)
    {
        mysqli_query($this->connect(), "INSERT INTO producer(distributor,company,contact,email,address) 
        VALUE('$distributor','$company','$contact','$email','$address')");
    }
    public function showProducer()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM producer");
        return $select;
    }
    public function deleteProducer($id)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM producer WHERE id =$id");
        return $delete;
    }
    public function editProducer($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM producer WHERE id =$id");
        return $select;
    }
    public function updateProducer($id, $distributor, $company, $contact, $email, $address)
    {
        $update = mysqli_query($this->connect(), "UPDATE producer SET distributor='$distributor',company='$company',contact='$contact',email='$email',address='$address' WHERE id = $id");
        return $update;
    }
    //<============================================ PRODUCER END ==================================================>//

    //<============================================ COMPANY START =================================================>//
    public function newCompany($companyname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM company WHERE companyname = '$companyname'");
        return $select;
    }
    public function addCompany($companyname)
    {
        mysqli_query($this->connect(), "INSERT INTO company(companyname) VALUE('$companyname')");
    }
    public function showCompany()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM company");
        return $select;
    }
    public function deleteCompany($id)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM company WHERE id =$id");
        return $delete;
    }
    public function editCompany($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM company WHERE id =$id");
        return $select;
    }
    public function updateCompany($id, $companyname)
    {
        $update = mysqli_query($this->connect(), "UPDATE company SET companyname='$companyname' WHERE id = $id");
        return $update;
    }
    //<============================================ COMPANY END ===================================================>//

    //<============================================ PRODUCT START =================================================>//
    public function newProduct($name, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$name' AND model = '$model' AND manufacturer = '$manufacturer'");
        return $select;
    }
    public function addProduct($name, $manufacturer, $model, $quantity, $cprice, $wprice, $rprice)
    {
        mysqli_query($this->connect(), "INSERT INTO product VALUE(null,'$name','$manufacturer','$model','$quantity','$cprice','$wprice','$rprice')");
    }
    public function addExcelproduct($name, $manufacturer, $model, $qty, $cprice, $wprice, $rprice)
    {
        mysqli_query($this->connect(), "INSERT INTO product VALUE(null,'$name','$manufacturer','$model','$qty','$cprice','$wprice','$rprice')");
    }
    public function addQtyExcel($name, $manufacturer, $model, $qty)
    {
        mysqli_query($this->connect(), "UPDATE product SET quantity = quantity+$qty WHERE name = '$name' AND manufacturer = '$manufacturer' AND model = '$model'");
    }
    public function updatePriceExcel($name, $manufacturer, $model, $cprice, $wprice, $rprice)
    {
        mysqli_query($this->connect(), "UPDATE product SET  cprice = '$cprice',wprice = '$wprice',rprice = '$rprice' WHERE name = '$name' AND manufacturer = '$manufacturer' AND model = '$model'");
    }
    public function showProduct()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product ORDER BY manufacturer ");
        return $select;
    }
    public function showProductPagination($offset, $records_per_page)
    {
        $sql = "SELECT * FROM product LIMIT $records_per_page OFFSET $offset";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function countProduct()
    {
        $sql = "SELECT COUNT(*) FROM product";
        $result = $this->connect()->query($sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
    public function showProductInput()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product GROUP BY name");
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
    public function updateProduct($id, $name, $model, $manufacturer, $quantity, $cprice, $wprice, $rprice)
    {
        $update = mysqli_query($this->connect(), "UPDATE product SET name='$name',model='$model',manufacturer='$manufacturer',quantity='$quantity',cprice='$cprice',wprice='$wprice',rprice='$rprice' WHERE id = $id");
        return $update;
    }

    //<============================================ PRODUCT END =================================================>//

    //<====================================================== DASHBOARD SALE START =================================================>//

    public function showDashboardSales()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE  date Like '%$date%'ORDER BY id DESC LIMIT 50");
        return $select;
    }

    public function showDashboardTotal()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(total) sumTotal FROM sales WHERE date LIKE '%$date%'");
        return $select;
    }
    public function showDashboardPos()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(pos) sumPos FROM sales WHERE date LIKE '%$date%'");
        return $select;
    }
    public function countDashboardCustomer()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT count(customer_name) as countcustomers FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showDashboardCredit()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(deposit) as credit FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showDashboardCash()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(cash) as cash FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showDashboardTransfer()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(transfer) as transfer FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showDashboardDebit()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(balance) as balance FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }

    //<====================================================== DASHBOARD SALE END ==================================================>//

    //<======================================== AJAX LOADING PRODUCT  START======================================>//
    public function ajaxSelectNameSales($customer_name)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE customer_name LIKE '%$customer_name%'  AND date LIKE '%$date%'");
        return $select;
    }
    public function ajaxSelectAddressSales($name, $address)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' AND date LIKE '%$date%' ");
        return $select;
    }

    public function productNameProduct($productname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%' GROUP BY name");
        return $select;
    }
    public function modelProduct($productname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$productname' GROUP BY model ");
        return $select;
    }
    public function manufacturerProduct($productname, $model)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$productname' AND model = '$model' ");
        return $select;
    }
    public function priceProduct($productname, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$productname' AND model = '$model' AND manufacturer = '$manufacturer'");
        return $select;
    }

    public function selectProductName($productname)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%'");
        return $select;
    }
    public function selectModel($productname, $model)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%' AND model LIKE '%$model%'");
        return $select;
    }
    public function selectManufacturer($productname, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name LIKE '%$productname%' AND model LIKE '%$model%' AND manufacturer LIKE '%$manufacturer%'");
        return $select;
    }
    public function selectSales($sales)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE customer_name LIKE '%$sales%' OR address LIKE '%$sales%' OR invoice_no LIKE '%$sales%' OR payment_type LIKE '%$sales%' OR date LIKE '%$sales%'");
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
    public function selectStaffname($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE staff_name LIKE '%$staffname%' AND date LIKE '%$date%'");
        return $select;
    }
    public function selectStaffnameTotal($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(total) as sumTotal FROM sales  WHERE  date LIKE '%$date%' AND staff_name LIKE '%$staffname%'");
        return $select;
    }
    public function selectStaffnameDeposit($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(deposit) as credit FROM sales  WHERE  date LIKE '%$date%' AND staff_name LIKE '%$staffname%'");
        return $select;
    }
    public function selectStaffnameTransfer($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(transfer) as transfer FROM sales  WHERE  date LIKE '%$date%' AND staff_name LIKE '%$staffname%'");

        return $select;
    }
    public function selectStaffnameCash($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(cash) as cash FROM sales  WHERE  date LIKE '%$date%' AND staff_name LIKE '%$staffname%'");
        return $select;
    }
    public function selectStaffnamePos($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(cash) as cash FROM sales  WHERE  date LIKE '%$date%' AND staff_name LIKE '%$staffname%'");
        return $select;
    }
    public function selectStaffnameDebit($staffname)
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT sum(balance) as balance FROM sales  WHERE  date LIKE '%$date%' AND staff_name LIKE '%$staffname%'");
        return $select;
    }
    public function selectReturnHistoryName($name)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_each_goods WHERE customer_name LIKE '%$name%'");
        return $select;
    }
    public function selectReturnHistoryinvoice_no($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_each_goods WHERE invoice_no LIKE '%$invoice_no%'");
        return $select;
    }
    public function selectReturnHistoryNameAddress($name, $address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_each_goods WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%'");
        return $select;
    }
    public function selectAllReturnHistoryName($name)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods WHERE customer_name LIKE '%$name%'");
        return $select;
    }
    public function selectAllReturnHistoryinvoice_no($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods WHERE invoice_no LIKE '%$invoice_no%'");
        return $select;
    }
    public function selectAllReturnHistoryNameAddress($name, $address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%'");
        return $select;
    }
    // public function showStaffnameTotal(){
    //     $date = date("d-m-Y");
    //     $select = mysqli_query($this->connect(),"SELECT sum(total) sumTotal FROM sales WHERE date LIKE '%$date%'");
    //     return $select;

    // }

    public function quantityProduct($productname, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM product WHERE name = '$productname' AND model = '$model' AND manufacturer = '$manufacturer'");
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
        $select =  mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name LIKE '%$name%'  AND id IN (SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address)");
        return $select;
    }
    public function selectDebitHistoryAddress($name, $address)
    {
        $select =  mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%'  AND id IN (SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address)");
        return $select;
    }
    public function ajaxShowInvoicestaff($staff_name)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE staff_name LIKE '%$staff_name%'");
        return $select;
    }
    public function selectDebitHistoryDate($name, $address, $date)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name LIKE '%$name%' AND address LIKE '%$address%' AND date LIKE '%$date%'");
        return $select;
    }
    public function showRecord($from, $to)
    {

        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE date BETWEEN '#$from#' AND '#$to#
                p'");
        return $select;
    }


    public function showRecordSales($date)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE  date Like '%$date%'ORDER BY id DESC");
        return $select;
    }
    public function showRecordInvoice($date, $invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE  date Like '%$date%' AND invoice_no LIKE '%$invoice%' ORDER BY id DESC");
        return $select;
    }
    public function showAllRecordSales()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM sales ORDER BY id DESC");
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
    public function showRecordTotal($date)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(total) as sumTotal FROM sales WHERE date LIKE '%$date%'");
        return $select;
    }
    public function countRecordCustomer($date)
    {
        $select = mysqli_query($this->connect(), "SELECT count(customer_name) as countcustomers FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showRecordCredit($date)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(deposit) as credit FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showRecordCash($date)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(cash) as cash FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showRecordTransfer($date)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(transfer) as transfer FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showRecordDebit($date)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(balance) as balance FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }
    public function showRecordPos($date)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(pos) as pos FROM sales  WHERE  date LIKE '%$date%'");
        return $select;
    }

    //<======================================== AJAX LOADING PRODUCT  END========================================>//

    //<============================================ SALES START =================================================>//
    // public function newsales($salesname){
    //     $select = mysqli_query($this->connect(),"SELECT * FROM sales WHERE salesname = '$salesname'");
    //     return $select;
    // }

    public function invoiceLock(){
        mysqli_query($this->connect(), "SELECT * FROM sales FOR UPDATE");
    }
    public function unlockInvoice(){
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
    public function addPos($customer_name, $address, $invoice_no2, $pos_type,$pos_charges)
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
    public function showInvoice()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE date LIKE '%$date%' ");
        return $select;
    }
    public function showInvoiceDirector()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE staff_name = '" . $_SESSION['directorfullname'] . "' AND date LIKE '%$date%' ORDER BY id DESC");
        return $select;
    }
    public function showInvoiceDate()
    {
        $date = date("d-m-Y");
        $select = mysqli_query($this->connect(), "SELECT * FROM sales WHERE date LIKE '%$date%' ORDER BY id DESC");
        return $select;
    }



    public function updateQty($qty, $productname_session, $model_session, $manufacturer_session)
    {
        $update = mysqli_query($this->connect(), "UPDATE product SET quantity = quantity - $qty WHERE name = '$productname_session' AND model='$model_session' AND manufacturer = '$manufacturer_session'");
        return $update;
    }

    //===========================================================================================================================

    public function updateCashReturn($new_cash, $total_paid, $new_balance, $invoice_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE sales SET cash = '$new_cash', deposit = '$total_paid', balance = '$new_balance' WHERE invoice_no = '$invoice_no'");
        return $update;
    }
    public function updateTransferReturn($new_transfer, $total_paid, $new_balance, $invoice_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE sales SET transfer = '$new_transfer', deposit = '$total_paid', balance = '$new_balance' WHERE invoice_no = '$invoice_no'");
        return $update;
    }
    public function sumAmountSales_details($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(amount) as total FROM sales_details WHERE invoice_no = '$invoice_no'");
        return $select;
    }
    public function updateTotalAfterReturn($new_total, $new_balance, $invoice_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE sales SET total = '$new_total', balance = '$new_balance' WHERE invoice_no = '$invoice_no'");
        return $update;
    }
    public function updateSalesDetails($rem_qty, $new_amount, $productname, $model, $manufacturer, $invoice_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE sales_details SET quantity = '$rem_qty', amount = '$new_amount' WHERE product_name = '$productname' AND model='$model' AND manufacturer = '$manufacturer' AND invoice_no = '$invoice_no'");
        return $update;
    }
    public function updateStockAfterEachReturn($return_qty, $productname, $model, $manufacturer)
    {
        $update = mysqli_query($this->connect(), "UPDATE product SET quantity = quantity+$return_qty WHERE name = '$productname' AND model='$model' AND manufacturer = '$manufacturer'");
        return $update;
    }
    public function updateEachReturn($invoice_no, $return_amount, $staff_name, $date)
    {
        $update = mysqli_query($this->connect(), "UPDATE return_each_goods SET total = total+$return_amount, staff_name = '$staff_name', date= '$date'  WHERE invoice_no = '$invoice_no'");
        return $update;
    }
    public function updateEachReturnDetails($invoice_no, $productname, $model, $manufacturer, $return_qty, $return_amount, $staff_name, $date)
    {
        $update = mysqli_query($this->connect(), "UPDATE return_goods_details SET quantity = quantity+$return_qty, amount = amount+$return_amount,staff_name = '$staff_name',date='$date' WHERE product_name = '$productname' AND model='$model' AND manufacturer = '$manufacturer' AND invoice_no = '$invoice_no'");
        return $update;
    }

    public function updateDebits($total_deposit, $total_bal1, $customer_name, $address)
    {
        $update = mysqli_query($this->connect(), "UPDATE debit SET  deposit = $total_deposit, balance = $total_bal1 WHERE customer_name = '$customer_name' AND address='$address'");
        return $update;
    }
    public function insertEachReturn($customer_name, $address, $invoice_no, $payment_type, $return_amount, $staff_name, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO return_each_goods VALUES(null,'$customer_name', '$address', '$invoice_no', '$payment_type', '$return_amount','$staff_name','$date')");
    }


    public function insertEachReturnDetails($customer_name, $address, $invoice_no, $productname, $model, $manufacturer, $return_qty, $price, $return_amount, $staff, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO return_goods_details(customer_name,address,invoice_no,product_name,model,manufacturer,quantity,price,amount,staff_name,date) VALUES('$customer_name', '$address', '$invoice_no', '$productname', '$model','$manufacturer', '$return_qty',  '$price','$return_amount','$staff','$date')");
    }

    public function insertDebitsDetailsReturn($customer_name, $address, $debit_total, $return_amount, $total_deposit, $total_bal1, $total_bal2, $staff_name, $date, $comment)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$debit_total','$return_amount','$total_deposit', '$total_bal1','$total_bal2','$staff_name',  '$date','$comment','')");
    }

    public function deleteSalesDetailsReturn($invoice_no)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales_details WHERE quantity =0 AND invoice_no = '$invoice_no'");
        return $delete;
    }

    public function deleteSalesReturn($invoice_no)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales WHERE total =0 AND invoice_no = '$invoice_no'");
        return $delete;
    }
    public function showReturnEach($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_each_goods where invoice_no = '$invoice_no' ");
        return $select;
    }
    public function showReturnEachDetails($invoice_no, $productname, $model, $manufacturer)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods_details WHERE invoice_no = '$invoice_no' AND product_name = '$productname' AND model = '$model' AND manufacturer = '$manufacturer'");
        return $select;
    }

    public function insertAllReturn($customer_name, $address, $invoice_no, $customer_type, $payment_type, $total, $cash, $transfer,$pos, $old_deposit, $deposit, $transport, $balance, $staff, $date, $username, $bank)
    {
        mysqli_query($this->connect(), "INSERT INTO return_goods VALUES(null,'$customer_name', '$address', '$invoice_no','$customer_type', '$payment_type', '$total','$cash','$transfer','$pos', '$old_deposit', '$deposit', '$transport', '$balance', '$staff',  '$date', '$username', '$bank')");
    }

    public function insertAllReturnDetails($customer_name1, $address1, $invoice_no1, $productname, $model, $manufacturer, $quantity, $price, $amount, $staff1, $date1)
    {
        mysqli_query($this->connect(), "INSERT INTO return_goods_details(customer_name,address,invoice_no,product_name,model,manufacturer,quantity,price,amount,staff_name,date) VALUES('$customer_name1', '$address1', '$invoice_no1', '$productname', '$model','$manufacturer', '$quantity',  '$price','$amount','$staff1','$date1')");
    }
    public function insertReturnDebitsDetails($customer_name, $address, $debit_total, $total, $new_deposit, $new_balance, $new_balance1, $staff, $date, $comment)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$debit_total','$total','$new_deposit', '$new_balance','$new_balance1','$staff',  '$date','$comment','')");
    }
    public function updateReturnDebits($new_deposit, $new_balance, $customer_name, $address)
    {
        $update = mysqli_query($this->connect(), "UPDATE debit SET  deposit = $new_deposit, balance = $new_balance WHERE customer_name = '$customer_name' AND address='$address'");
        return $update;
    }
    public function showReturn()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods ");
        return $select;
    }
    public function showEachReturn()
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_each_goods");
        return $select;
    }
    public function showInvoiceReturnEach($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_each_goods WHERE invoice_no ='$invoice'");
        return $select;
    }
    public function showInvoiceReturn($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM return_goods WHERE invoice_no ='$invoice'");
        return $select;
    }
    public function showReturnTotal($invoice)
    {
        $select = mysqli_query($this->connect(), "SELECT sum(amount) as total FROM return_goods_details  WHERE invoice_no = '$invoice'");
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
    public function deletesalesDetails($invoice)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM sales_details WHERE invoice_no =$invoice");
        return $delete;
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
    public function showDebitHistoriesTotalPaidTotalBal($customer_name, $address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name ='$customer_name' AND address = '$address' ORDER BY id DESC LIMIT 1");
    }
    public function chechDebitDetails($customer_name, $address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name ='$customer_name' AND address = '$address'");
    }

    public function updateFromDebitBook($total, $deposit, $balance, $customer_name, $address)
    {
        mysqli_query($this->connect(), "UPDATE debit SET total = total + $total, deposit = deposit + $deposit, balance = balance + $balance WHERE customer_name='$customer_name' AND address='$address'");
    }
    public function addIntoDebitDetails($customer_name, $address, $total, $deposit, $total_deposit, $balance, $total_bal, $staff, $date, $comment)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$total','$deposit','$total_deposit', '$balance','$total_bal', '$staff', '$date','$comment','')");
    }
    public function showDebit()
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit");
    }
    public function showSumTotalDebit()
    {
        return mysqli_query($this->connect(), "SELECT sum(total) as total_amount FROM debit_histories");
    }
    public function showDebitHistories()
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE id IN (SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address)");
    }
    public function showDebitTotalPaidTotalBal($customer_name, $address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM debit WHERE customer_name = '$customer_name' AND address = '$address'");
    }
    public function deleteDebit()
    {
        mysqli_query($this->connect(), "DELETE FROM debit WHERE balance = 0");
    }
    public function updateDebitHistories($settled)
    {
        mysqli_query($this->connect(), "UPDATE debit_histories SET comments = '$settled' WHERE total_balance = 0");
    }
    public function updateDebitHistories1($customer_name, $address, $deposit, $balance, $staff, $date, $id)
    {
        mysqli_query($this->connect(), "UPDATE debit_histories SET customer_name = '$customer_name' AND address = '$address' AND deposit = '$deposit' AND balance = '$balance' AND staff_name = '$staff' AND date = '$date' WHERE id = '$id'");
    }
    public function editDebit($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit WHERE id =$id");
        return $select;
    }
    public function editDebitHistory($id)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE id =$id");
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
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$total','$pay','$total_paid', '$new_balance','$total_bal','$staff',  '$date','$comment','')");
    }
    public function debitView($customer_name, $customer_address)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE customer_name ='$customer_name' AND address ='$customer_address'");
        return $select;
    }
    // public function export(){
    //     $connection = mysqli_connect('localhost','root','','inventory');
    //     $tables = array();
    //     $result = mysqli_query($connection,"SHOW TABLES");
    //     while($row = mysqli_fetch_row($result)){
    //       $tables[] = $row[0];
    //     }
    //     $return = '';
    //     foreach($tables as $table){
    //       $result = mysqli_query($connection,"SELECT * FROM ".$table);
    //       $num_fields = mysqli_num_fields($result);

    //       $return .= 'DROP TABLE '.$table.';';
    //       $row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
    //       $return .= "\n\n".$row2[1].";\n\n";

    //       for($i=0;$i<$num_fields;$i++){
    //         while($row = mysqli_fetch_row($result)){
    //           $return .= "INSERT INTO ".$table." VALUES(";
    //           for($j=0;$j<$num_fields;$j++){
    //             $row[$j] = addslashes($row[$j]);
    //             if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
    //             else{ $return .= '""';}
    //             if($j<$num_fields-1){ $return .= ',';}
    //           }
    //           $return .= ");\n";
    //         }
    //       }
    //       $return .= "\n\n\n";
    //     }
    //     //save file
    //     $handle = fopen("../database/inventory.sql","w+");
    //     fwrite($handle,$return);
    //     fclose($handle);
    // }
    public function deleteTransfer($invoice_no)
    {
        $delete = mysqli_query($this->connect(), "DELETE FROM bank WHERE invoice_no = $invoice_no");
        return $delete;
    }
    public function checkBankExist($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM bank WHERE invoice_no ='$invoice_no'");
        return $select;
    }
    public function updateBank($new_transfer, $bank_name, $staff, $date, $invoice_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE bank SET transfer_amount = '$new_transfer', bank_name = '$bank_name', staff = '$staff', date = '$date'  WHERE invoice_no = '$invoice_no'");
        return $update;
    }
    public function updatePaymentSales($new_transfer, $new_cash, $new_pos, $total_paid, $new_balance, $payment_type, $invoice_no)
    {
        $update = mysqli_query($this->connect(), "UPDATE sales SET transfer = '$new_transfer', cash = '$new_cash',pos = '$new_pos',  deposit = '$total_paid', balance = '$new_balance', payment_type = '$payment_type' WHERE invoice_no = '$invoice_no'");
        return $update;
    }
    public function updateDebitPayment($new_payment, $customer_name, $address)
    {
        mysqli_query($this->connect(), "UPDATE debit SET  deposit = deposit+$new_payment, balance = balance-$new_payment WHERE customer_name='$customer_name' AND address='$address'");
    }
    public function updateDebitHistoriesPayment($updated_deposit, $updated_total_deposit, $updated_balance, $updated_total_balance, $invoice_no)
    {
        mysqli_query($this->connect(), "UPDATE debit_histories SET  deposit = '$updated_deposit',total_paid='$updated_total_deposit', balance = '$updated_balance',total_balance = '$updated_total_balance' WHERE invoice_no='$invoice_no'");
    }
    public function addDebitsPayment($customer_name, $address, $total, $total_paid, $new_balance, $staff, $date)
    {
        mysqli_query($this->connect(), "INSERT INTO debit VALUES(null,'$customer_name', '$address', '$total','$total_paid', '$new_balance','$staff',  '$date')");
    }
    public function addDebitHistoriesPayment($customer_name, $address, $total, $total_paid, $new_balance, $staff, $date, $comment, $invoice_no)
    {
        mysqli_query($this->connect(), "INSERT INTO debit_histories VALUES(null,'$customer_name', '$address', '$total','$total_paid','$total_paid', '$new_balance','$new_balance','$staff',  '$date','$comment','$invoice_no')");
    }
    public function checkDebitInvoice($invoice_no)
    {
        $select = mysqli_query($this->connect(), "SELECT * FROM debit_histories WHERE invoice_no ='$invoice_no'");
        return $select;
    }
    public function checkInvoice()
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
    public function depositAddDetails($customer_name, $customer_address, $invoice_no, $product_name, $model_input, $manufacturer_input, $date, $staff)
    {
        mysqli_query($this->connect(), "INSERT INTO deposit_details (customer_name, customer_address,invoice_no, product_name, model, manufacturer,date,staff) VALUES ('$customer_name', '$customer_address','$invoice_no','$product_name', '$model_input', '$manufacturer_input','$date','$staff')");
    }
    public function depositUpdate($customer_name, $customer_address,$invoice_no, $cash, $transfer, $pos, $deposit_amount, $date, $staff)
    {
        mysqli_query($this->connect(), "UPDATE deposit SET invoice_no = '$invoice_no', cash = cash+$cash, transfer = transfer+$transfer, pos = pos+$pos, deposit_amount = deposit_amount+$deposit_amount, date = '$date', staff = '$staff' WHERE customer_name='$customer_name' AND customer_address='$customer_address'");
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
    public function checkSupply($customer_name,$address,$invoice_no,$supplied_by,$checked_by){
        mysqli_query($this->connect(), "INSERT INTO supply_check VALUES(null,'$customer_name', '$address', '$invoice_no', '$supplied_by','$checked_by')");

    }
    public function showSupplyCheck($invoice_no, $customer_name, $customer_address)
    {
        return mysqli_query($this->connect(), "SELECT * FROM supply_check WHERE invoice_no = '$invoice_no' AND customer_name = '$customer_name' AND customer_address = '$customer_address'");
    }
    public function showBulkSMS(){
        return mysqli_query($this->connect(), "SELECT * FROM bulk_sms ");
    }
    public function storeSMS($title,$message){
        mysqli_query($this->connect(), "INSERT INTO bulk_sms VALUES(null,'$title', '$message')");
    }
    public function showCode($code)
    {
        return mysqli_query($this->connect(), "SELECT * FROM code WHERE code = '$code'");
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
