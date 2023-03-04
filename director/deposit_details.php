<?php
session_start();

include "core/init.php";
Session::directorAccess("directorusername");

?>
<?php
$ctr = new Controller();
// $ctr->print("sales_history.php");


$ctr->viewDepositDetails();
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
    <div class="container">
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
                <table class="table table-striped table-light table-bordered" style="width: 70%;">
                    <tr style="width: 50%;">
                        <th>NAME: </th>
                        <td><?php echo $ctr->viewDeposit("customer_name"); ?></td>
                        <th>ADDRESS:</th>
                        <td><?php echo $ctr->viewDeposit("customer_address"); ?></td>


                    </tr>

                    <tr>
                        <th>INVOICE NO:</th>
                        <td><?php echo $ctr->viewDeposit("invoice_no"); ?></td>
                        <th>PAYMENT TYPE:</th>
                        <td><?php echo $ctr->viewDeposit("payment_type"); ?></td>
                    </tr>

                    <tr">
                        <th>DATE:</th>
                        <td><?php echo $ctr->viewDeposit("date"); ?></td>
                        <th>SOLD BY:</th>
                        <td>Mr/Miss <?php $staff = explode(" ", $ctr->viewDeposit("staff"));
                                    echo $staff[1]; ?></td>
                        </tr>

                </table>

            </div>
        </div>

        <div class="row" style="font-size: 18px;">
            <div class="col-sm-12">
                <table class="table table-striped table-light table-bordered" style="width: 100%;">
                    <tr>
                        <th>S/N</th>
                        <th>Item</th>
                        <th>Model</th>
                        <th>Manufacturer</th>
                    </tr>
                    <?php
                    $id = 0;
                    $result = $ctr->viewDepositDetails();
                    while ($row = mysqli_fetch_array($result)) { ?>

                        <tr>
                            <td><?php echo ++$id ?></td>
                            <td><?php echo $row["product_name"] ?></td>
                            <td><?php echo $row["model"] ?></td>
                            <td><?php echo $row["manufacturer"] ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td style="font-weight: bold;">Cash: # <?php echo $ctr->viewDeposit("cash"); ?></td>
                        <td style="font-weight: bold;">POS:# <?php echo $ctr->viewDeposit("pos"); ?></td>
                        <td style="font-weight: bold;">Transfer:# <?php echo $ctr->viewDeposit("transfer"); ?></td>

                        <td style="font-weight: bold;">Deposit Amount:# <?php echo $ctr->viewDeposit("deposit_amount"); ?></td>
                    </tr>

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
        <div class="row">
            <div class="col-12 text-center">
                <form action="" method="post">
                    <input name="print" type="submit" class="btn btn-primary d-print-none" value="print" onclick="printpage()">
                    <a href="../print/director/deposit_s.php?invoice_no=<?php $ctr->viewDeposit("invoice_no"); ?>" class="btn btn-success d-print-none">Print Retail</a>
                    <a href="show_deposit.php" class="btn btn-info d-print-none">Go Back</a>

                </form>
            </div>
        </div>
    </div>

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