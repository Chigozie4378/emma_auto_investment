
<?php
include '_partial.php';

$debit_history_ctr = new DebitHistoriesController();
$debit_history = $debit_history_ctr->checkDebit($_SESSION["customer_name"], $_SESSION["address"]);
$debit_history_result = mysqli_fetch_assoc($debit_history);

$sales_history_ctr = new SalesHistoriesController();
$sales_history = $sales_history_ctr->getSales($_SESSION["invoice"]);
$sales_history_result = mysqli_fetch_assoc($sales_history);

$sales_ctr = new SalesController();
$sales_ctr->saveSupplyCheck();



include "../includes/shared/header.php";

?>

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
                            <td><?php echo $sales_history_result["customer_name"]; ?></td>
                            <th>ADDRESS:</th>
                            <td><?php echo $sales_history_result["address"]; ?></td>
                        </tr>

                        <tr class="odd gradeA">
                            <th>INVOICE NO:</th>
                            <td><?php echo $sales_history_result["invoice_no"]; ?></td>
                            <th>PAYMENT TYPE:</th>
                            <td><?php echo $sales_history_result["payment_type"]; ?></td>
                        </tr>

                        <tr class="even gradeA">
                            <th>DATE:</th>
                            <td><?php echo $sales_history_result["date"]; ?></td>
                            <th>Sold By:</th>
                            <td>Mr/Miss <?php $staff = explode(" ", $sales_history_result['staff_name']);
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
                $select = $sales_history_ctr->getSalesDetails($_SESSION["invoice"]);
                while ($row = mysqli_fetch_array($select)) {
                ?>
                    <tr>
                        <td><?php echo $id++ ?></td>
                        <td style="font-weight: bold;"><?php echo $row["quantity"] ?></td>
                        <td><?php echo $row["product_name"] ?></td>
                        <td><?php echo $row["model"] ?></td>
                        <td><?php echo $row["manufacturer"] ?></td>
                        <td><?php echo $row["price"] ?></td>
                        <td><?php echo $row["amount"] ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="5"></td>
                    <td style="font-weight: bold;">Total Amount:</td>
                    <td style="font-weight: bold;"># <?php echo number_format($sales_history_result["total"], 2); ?></td>
                </tr>
                <tr>
                    <?php
                    if ($sales_history_result["old_deposit"] != 0) { ?>
                        <td style="font-weight: bold;">Old Deposit:# <?php echo number_format($sales_history_result["old_deposit"], 2); ?></td>
                    <?php }
                    ?>
                    <?php
                    if ($sales_history_result["deposit"] > $sales_history_result["total"]) { ?>
                        <td style="font-weight: bold;">Transport Charges: # <?php echo number_format($sales_history_result["transport"], 2); ?></td>

                    <?php }
                    ?>

                    <td style="font-weight: bold;">Cash:# <?php echo number_format($sales_history_result["cash"], 2); ?></td>
                    <td style="font-weight: bold;">Transfer:# <?php echo number_format($sales_history_result["transfer"], 2); ?></td>
                    <td style="font-weight: bold;">POS:# <?php echo number_format($sales_history_result["pos"], 2);
                                                            if ($sales_history_result["pos"] != 0) {
                                                                $select_pos = mysqli_fetch_assoc($sales_history_ctr->showPos($_SESSION["customer_name"], $_SESSION["address"], $_SESSION["invoice"]));
                                                                echo " (" . $select_pos["pos_type"] . ")"; ?>
                    </td>
                    <td style="font-weight: bold;">POS Charges:# <?php echo number_format($select_pos["pos_charges"], 2);
                                                                }
                                                                    ?>
                    </td>
                    <td style="font-weight: bold;">Total Payment:</td>
                    <td style="font-weight: bold;"><?php echo number_format((int)$sales_history_result["deposit"] + (int)$select_pos["pos_charges"], 2); ?></td>
                </tr>
                <?php

                if ($sales_history_result["balance"] != 0 or mysqli_num_rows($debit_history) > 0) { ?>
                    <tr>
                        <td colspan="2"></td>
                        <td style="font-weight: bold;">Transport Charges: # <?php echo number_format($sales_history_result["transport"], 2); ?></td>
                        <td style="font-weight: bold;">Old Balance: </td>
                        <td style="font-weight: bold;"># <?php echo number_format($debit_history_result["balance"] - $sales_history_result["balance"], 2); ?></td>
                        <td style="font-weight: bold;">Total Balance:</td>
                        <td style="font-weight: bold;"># <?php echo number_format($debit_history_result["balance"], 2); ?></td>

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
            <form action="" method="post">
                <div class="form-inline" style="float: right;">
                    <label for="pwd">Supplied By:</label>
                    <select class="form-control" name="supplied_by" style="width:210px" onchange="selectProduct(this.value)">
                        <option value=""></option>
                        <?php
                        $select_user_supply = $sales_history_ctr->showUserSupply();
                        while ($row = mysqli_fetch_assoc($select_user_supply)) { ?>
                            <option value="<?php echo $row['lastname'] ?>">
                                <?php echo  $row['lastname'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="offset-md-6 col-md-6">

            <div class="form-inline" style="float: right;">
                <label for="pwd">Checked By:</label>
                <input type="text" name="checked_by" class="form-control" id="pwd">

            </div>
        </div>
    </div>

    <div class="text-center">
        <b><i>You Must be Born Again!</i></b>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">

            <input onclick="window.print()" name="print" type="submit" class="toggle btn btn-primary d-print-none" value="print">
            </form>


        </div>
    </div>

    </div>
    <script>
        function printpage() {
            window.print()
        }
    </script>

    <!-- jQuery -->
    <script src="<?= $basePath ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= $basePath ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= $basePath ?>assets/plugins/chosen/chosen.js"></script>
    <script>
        $(".chosen").chosen();
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= $basePath ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= $basePath ?>assets/dist/js/adminlte.js"></script>

</body>

</html>

<!--Action boxes-->


<!--end-main-container-part-->
<?php

?>