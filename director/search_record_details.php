<?php
session_start();

include "core/init.php";
Session::directorAccess("directorusername");

?>
<?php
$ctr = new Controller();
// $ctr->print("sales_history.php");


$ctr->returnAllGoods();
$show = $ctr->viewSalesDetailDebit();
$show_result = mysqli_fetch_array($show);
?>
<?php //$ctr->addEachReturn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="icon" href="../assets/images/logo.jpg" type="image/gif" sizes="20x20">

    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
    <style>
        /* th,td{
            font-size: 15px;
            font-weight:700;
        } */
    </style>
</head>

<body>
    <div class="container-fluid" style="padding-right:30px;padding-left:30px;padding-bottom:160px;margin: bottom 120px;">
        <address class="text-center" style="padding-top:30px;">
            <h4 class="text-dark" style="font-size:39px;font-weight:bolder"><span><img src="../assets/images/depositphotos_143229717-stock-illustration-sport-superbike-motorcycle-with-helmet.jpg" alt="" style="height:80px;width:100px">
                </span>EMMA AUTO AND MULTI-SERVICES COMPANY</h4>
            <p class="text-dark" style="font-size:18px;">Distributor for Chanlin, Shiroro, Unigo, Jeely, Jieng, Endurance, Tako, Donaten, Sinosat,
                and Sunrain Motorcycle spare parts of all brands of Motorcycles and Tricycle parts all Genuine parts, such as Honda, Bajaj, TVS, Hero and all brands of Motorcycles Engine and Tricycles. <br>
                <span>Address: No. 37A, Opposite Jesus Life Church, Asubiaro Hospital Junction, Osogbo, Osun State.</span></br>   
                <span style="font-weight: bold">Tel: 08062063060, 08119222292, 07063684266</span>
            </p>
            <span class="bg-danger rounded-pill px-2"">Invoice</span>
               
        </address>
        <div class=" row" style="font-size: 18px;">
                <div class="col-md-8">
                    <table class="table table-striped table-light table-bordered" style="width: 100%;">
                        <tr style="width: 50%;">
                            <th>NAME: </th>
                            <td><?php echo $ctr->viewSalesDetail("customer_name"); ?></td>
                            <th>ADDRESS:</th>
                            <td><?php $ctr->viewSalesDetail("address"); ?></td>


                        </tr>

                        <tr>
                            <th>INVOICE NO:</th>
                            <td><?php $ctr->viewSalesDetail("invoice_no"); ?></td>
                            <th>PAYMENT TYPE:</th>
                            <td><?php $ctr->viewSalesDetail("payment_type"); ?></td>
                        </tr>

                        <tr">
                            <th>DATE:</th>
                            <td><?php $ctr->viewSalesDetail("date"); ?></td>
                            <th>SOLD BY:</th>
                            <td>Mr/Miss <?php $staff = explode(" ", $ctr->viewSalesReceipt("staff_name"));
                                        echo $staff[1]; ?></td>
                            </tr>

                    </table>

                </div>
    </div>
    <div class="row" style="font-size: 18px;">
        <div class="col-sm-12">
            <h1 id='returnQty'></h1>
            <p id="new_cash"></p>
            <table class="table table-striped table-light table-bordered">
                <tr>
                    <th>S/N</th>
                    <th>Qty</th>
                    <th>Item</th>
                    <th>Model</th>
                    <th>Manufacturer</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th class="d-print-none">Return good</th>
                </tr>
                <?php
                $id = 0;
                $result = $ctr->viewSalesDetails();
                while ($row = mysqli_fetch_array($result)) { ?>

                    <tr>
                        <td><?php echo ++$id ?></td>
                        <td style="font-weight:bold;"><?php echo $row["quantity"] ?></td>
                        <td><?php echo $row["product_name"] ?></td>
                        <td><?php echo $row["model"] ?></td>
                        <td><?php echo $row["manufacturer"] ?></td>
                        <td><?php echo $row["price"] ?></td>
                        <td><?php echo $row["amount"] ?></td>
                        <td class="d-print-none">
                            <input name="rQty" id="rQty<?php echo $row['id'] ?>" style="width:40px" type="text" placeholder="<?php echo $row["quantity"] ?>">&nbsp;&nbsp;&nbsp;&nbsp;
                            <i type="submit" class="fa fa-undo text-danger" onclick="returnEachGoods('<?php echo $row['quantity'] ?>','<?php echo $row['product_name'] ?>','<?php echo $row['model'] ?>','<?php echo $row['manufacturer'] ?>','<?php echo $row['price'] ?>','<?php echo $row['amount'] ?>','<?php $ctr->viewSalesDetail('invoice_no'); ?>','<?php $ctr->viewSalesDetail('total'); ?>',document.getElementById('rQty<?php echo $row['id'] ?>').value,'<?php echo $ctr->viewSalesDetail('customer_name'); ?>','<?php echo $ctr->viewSalesDetail('address'); ?>','<?php echo $ctr->viewSalesDetail('payment_type'); ?>','<?php echo $ctr->viewSalesDetail('cash'); ?>','<?php echo $ctr->viewSalesDetail('transfer'); ?>','<?php echo $ctr->viewSalesDetail('deposit'); ?>','<?php echo $ctr->viewSalesDetail('balance'); ?>','<?php echo date('d-m-Y') ?>','<?php echo $_SESSION['directorfullname']; ?>')"></i>

                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="5"></td>
                    <td style="font-weight: bold;">Total Amount:</td>
                    <td style="font-weight: bold;"><?php $ctr->viewSalesDetail("total"); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <form action="" method="post">
                        <td class="d-print-none" style="font-weight: bold;">Cash: <input onclick="this.select()" style="width:90px" type="text" id="cash1" required></td>
                        <td class="d-print-none" style="font-weight: bold;">Transfer: <input onclick="this.select()" onkeyup="selectBank()" style="width:90px" type="text" id="transfer1" required>
                        <span id="select_bank"></span></td>
                        <td class="d-print-none" style="font-weight: bold;">POS: <input onclick="this.select()" style="width:90px" type="text" id="pos1" required></td>
                        <td> <button type="submit" onclick="updatePayment('<?php $ctr->viewSalesDetail('invoice_no'); ?>',getElementById('transfer1').value,getElementById('bank').value,'<?php $ctr->viewSalesDetail('deposit') ?>','<?php $ctr->viewSalesDetail('total') ?>','<?php echo $ctr->viewSalesDetail('customer_name'); ?>','<?php echo $ctr->viewSalesDetail('address'); ?>','<?php echo date('d-m-Y') ?>','<?php echo $_SESSION['directorfullname']; ?>',getElementById('cash1').value,'<?php echo $ctr->viewSalesDetail('customer_type'); ?>',getElementById('pos1').value)" type="submit" class=" btn btn-sm btn-info d-print-none">Change Payment</button></td>
                    </form>
                    <td style="font-weight: bold;">Cash: # <?php $ctr->viewSalesDetail("cash"); ?></td>
                    <td style="font-weight: bold;">POS:# <?php $ctr->viewSalesDetail("pos"); ?></td>
                    <td style="font-weight: bold;">Transfer:# <?php $ctr->viewSalesDetail("transfer"); ?></td>

                    <td style="font-weight: bold;">Total Paid:</td>
                    <td style="font-weight: bold;"># <?php $ctr->viewSalesDetail("deposit"); ?></td>
                    <td class="d-print-none"></td>
                </tr>
                <?php

                if (mysqli_num_rows($show)>0) { ?>
                    <tr>
                        <td colspan="3"></td>
                        <td style="font-weight: bold;">Old Balance: </td>
                        <td style="font-weight: bold;"># <?php echo number_format($show_result["balance"] - $ctr->viewSalesReceipt("balance"), 2); ?></td>
                        <td style="font-weight: bold;">Total Balance:</td>
                        <td style="font-weight: bold;"># <?php echo number_format($show_result["balance"], 2); ?></td>
                    </tr>
                <?php }
                ?>
            </table>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <div class="form-inline">
                <label for="email">Customer Signature:</label>
                <input type="text" class="form-control" id="email">


            </div>
        </div>
        <div class="col-md-6">

            <div class="form-inline" style="float: right;">
                <label for="pwd">Manager Signature:</label>
                <input type="text" class="form-control" id="pwd">

            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="offset-md-6 col-md-6">

            <div class="form-inline" style="float: right;">
                <label for="pwd">Supplied By:</label>
                <input type="text" class="form-control" id="pwd">

            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="offset-md-6 col-md-6">

            <div class="form-inline" style="float: right;">
                <label for="pwd">Checked By:</label>
                <input type="text" class="form-control" id="pwd">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <form action="" method="post">
                <input name="print" type="submit" class="btn btn-primary d-print-none" value="print" onclick="printpage()">
                <a href="../print/director/index_s.php?invoice_no=<?php $ctr->viewSalesDetail("invoice_no"); ?>" class="btn btn-success d-print-none">Print Retail</a>
                <a href="sales_history_details.php?invoice_no1=<?php $ctr->viewSalesDetail("invoice_no") ?>" class="btn btn-danger d-print-none">Return All Goods</a>
                <a href="search_record.php" class="btn btn-info d-print-none">Go Back</a>

            </form>
            <p></p>



        </div>
    </div>
    </div>

    <script>
        function returnEachGoods(value1, value2, value3, value4, value5, value6, value7, value8, value9, value10, value11, value12, value13, value14, value15, value16, value17, value18) {
            $(document).ready(function() {
                var quantity = value1;
                var productname = value2;
                var model = value3;
                var manufacturer = value4;
                var price = value5;
                var amount = value6;
                var invoice_no = value7;
                var total_amount = value8;
                var returnQty = value9;
                var customer_name = value10;
                var address = value11;
                var payment_type = value12;
                var cash = value13;
                var transfer = value14;
                var deposit = value15;
                var balance = value16;
                var date = value17;
                var staff = value18;

                if (returnQty != "") {
                    $.ajax({
                        url: "ajax/load_return_qty.php",
                        method: 'POST',
                        data: {
                            quantity: quantity,
                            productname: productname,
                            model: model,
                            manufacturer: manufacturer,
                            price: price,
                            amount: amount,
                            invoice_no: invoice_no,
                            total_amount: total_amount,
                            returnQty: returnQty,
                            customer_name: customer_name,
                            address: address,
                            payment_type: payment_type,
                            cash: cash,
                            transfer: transfer,
                            deposit: deposit,
                            balance: balance,
                            date: date,
                            staff: staff
                        },
                        success: function(data) {
                            $('#returnQty').html(data);
                        }
                    });
                } else {
                    $('#qty').css('display', 'none');
                }
            });

        }
        function updatePayment(value1, value2, value3, value4, value5, value6, value7, value8, value9, value10, value11, value12) {
            $(document).ready(function() {
                var invoice_no = value1;
                var new_transfer = value2;
                var bank = value3;
                var deposit = value4;
                var total = value5;
                var customer_name = value6;
                var address = value7;
                var date = value8;
                var staff = value9;
                var new_cash = value10;
                var customer_type = value11;
                var pos = value12;
                if (new_transfer != "" && new_cash != "") {
                    $.ajax({
                        url: "ajax/load_update_payment.php",
                        method: 'POST',
                        data: {
                            invoice_no: invoice_no,
                            deposit: deposit,
                            bank: bank,
                            new_transfer: new_transfer,
                            total: total,
                            customer_name: customer_name,
                            address: address,
                            date: date,
                            staff: staff,
                            new_cash: new_cash,
                            customer_type:customer_type,
                            new_pos:pos
                        },
                        success: function(data) {
                            $('#new_cash').html(data);
                        }
                    });
                }


            });

        }

        function selectBank() {

            const xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("select_bank").innerHTML =
                        this.responseText;
                }
            };
            xhttp.open("GET", "sales_ajax/load_select_bank.php", true);
            xhttp.send();
        }
    </script>
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.js"></script>

    <script src="../assets/dist/js/demo.js"></script>
    <script>
        function printpage() {
            window.print()
        }
    </script>



</body>

</html>

<!--Action boxes-->


<!--end-main-container-part-->
<?php

?>