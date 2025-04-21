<?php
include '../helpers/_partial.php';
$debit_history_ctr = new DebitHistoriesController();
$sales_history_ctr = new SalesHistoriesController();
$deposit_ctr = new DepositController();
?>
<?php
// $ctr = new Controller();
// if (isset($_POST["print"])) {

//     header("location:sales_history.php");
// }

// $ctr->returnAllGoods();
// $show = echo $sales_history_ctr->showSalesDebit();
// $show_result = mysqli_fetch_array($show);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="icon" href="../assets/images/logo.jpg" type="image/gif" sizes="20x20">
    <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
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
        <div class=" row">
                <div class="col-md-8">
                    <table class="table table-striped table-light table-bordered" style="width: 100%;">
                        <tr style="width: 50%;">
                            <th>NAME: </th>
                            <td><?php echo $sales_history_ctr->showSales("customer_name"); ?></td>
                            <th>ADDRESS:</th>
                            <td><?php echo $sales_history_ctr->showSales("address"); ?></td>


                        </tr>

                        <tr class="odd gradeA">
                            <th>INVOICE NO:</th>
                            <td><?php echo $sales_history_ctr->showSales("invoice_no"); ?></td>
                            <th>PAYMENT TYPE:</th>
                            <td><?php echo $sales_history_ctr->showSales("payment_type"); ?></td>
                        </tr>

                        <tr class="even gradeA">
                            <th>DATE:</th>
                            <td><?php echo $sales_history_ctr->showSales("date"); ?></td>
                            <th>SOLD BY:</th>
                            <td>Mr/Miss <?php $staff = explode(" ", $sales_history_ctr->showSales("staff_name"));
                                        echo $staff[1]; ?></td>

                        </tr>

                    </table>

                </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-light table-bordered">
                <tr>
                    <th>S/N</th>
                    <th>Qty</th>
                    <th>Item</th>
                    <th>Model</th>
                    <th>Manufacturer</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
                <?php
                $id = 1;
                $result = $sales_history_ctr->showSalesDetails();
                while ($row = $result->fetch_assoc()) { ?>

                    <tr>
                        <td><?php echo ++$id ?></td>
                        <td style="font-weight: bold;"><?php echo $row["quantity"] ?></td>
                        <td><?php echo $row["product_name"] ?></td>
                        <td><?php echo $row["model"] ?></td>
                        <td><?php echo $row["manufacturer"] ?></td>
                        <td><?php echo $row["price"] ?></td>
                        <td><?php echo $row["amount"] ?></td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="5"></td>
                    <td style="font-weight: bold;">Total Amount:</td>
                    <td style="font-weight: bold;"># <?php echo $sales_history_ctr->showSales("total"); ?></td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <?php
                    if ($sales_history_ctr->showSales("old_deposit") > 0) { ?>
                        <td style="font-weight: bold;">Old Deposit: # <?php echo $sales_history_ctr->showSales("old_deposit"); ?></td>
                    <?php }
                    ?>
                    <?php
                    if (($sales_history_ctr->showSales("deposit") > $sales_history_ctr->showSales("total") && $sales_history_ctr->showSales("transport") > 0)) { ?>
                        <td style="font-weight: bold;">Transport Charges: # <?php echo $sales_history_ctr->showSales("transport") ?></td>

                    <?php }
                    ?>
                    <td style="font-weight: bold;">Cash: # <?php echo $sales_history_ctr->showSales("cash"); ?></td>

                    <td style="font-weight: bold;">Transfer: # <?php echo $sales_history_ctr->showSales("transfer"); ?></td>
                    <td style="font-weight: bold;">POS:# <?php echo $sales_history_ctr->showSales("pos");
                                                            if ($sales_history_ctr->showSales("pos") != 0) {
                                                                echo " (" . $sales_history_ctr->showPosType("pos_type") . ")"; ?></td>
                    <td style="font-weight: bold;">POS Charges : # <?php echo $sales_history_ctr->showPosType("pos_charges");
                                                                }  ?>
                    <td style="font-weight: bold;">Total Paid: # <?php $deposit = $sales_history_ctr->showSales("deposit");
                                                                    $pos_charges =  $sales_history_ctr->showPosType("pos_charges");
                                                                    $total_paid = intval($deposit) + intval($pos_charges);
                                                                    echo ($total_paid); ?></td>

                </tr>
                <?php


                if ($debit_history_ctr->countDebit() > 0) { ?>
                    <tr>
                        <td colspan="2"></td>
                        <td style="font-weight: bold;">Transport Charges: # <?php echo $sales_history_ctr->showSales("transport"); ?></td>
                        <td style="font-weight: bold;">Old Balance: </td>
                        <td style="font-weight: bold;"># <?php $old_bal = $debit_history_ctr->showDebit("balance") - $sales_history_ctr->showSales("balance");
                                                            echo number_format($old_bal, 2); ?></td>
                        <td style="font-weight: bold;">Total Balance:</td>
                        <td style="font-weight: bold;"># <?php echo number_format($debit_history_ctr->showDebit("balance"), 2); ?></td>

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
                <input type="text" class="form-control" id="pwd" value=" <?php echo $sales_history_ctr->supplyCheck('supplied_by') ?>" readonly>


            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="offset-md-6 col-md-6">

            <div class="form-inline" style="float: right;">
                <label for="pwd">Checked By:</label>
                <input type="text" class="form-control" id="pwd" value=" <?php echo $sales_history_ctr->supplyCheck('checked_by') ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
        <?php
            if (strtolower($sales_history_ctr->showSales("customer_type")) === "deposit") { ?>
                <form action="" method="post" class="pb-5">
                    <a href="javascript:history.back()" class="btn btn-default">Go Back</a>
                    <a href="../print/deposit_s.php?invoice_no=<?php echo $deposit_ctr->viewDeposit("invoice_no"); ?>" class="btn btn-primary d-print-none">Reprint Deposit</a>
                </form>
            <?php
            } else { ?>
                <form action="" method="post">
                <a href="javascript:history.back()" class="btn btn-default d-print-none">Go Back</a>
                    <input name="print" type="submit" class="btn btn-primary d-print-none" value="print" onclick="printpage()">
                    
                </form>
            <?php }
            ?>

            <p></p>


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