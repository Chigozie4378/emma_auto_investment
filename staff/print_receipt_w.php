<?php
session_start();

include "core/init.php";

$mod = new Model;
?>
<?php

$show = $mod->showDebitInvoice($_SESSION["customer_name"], $_SESSION["address"]);
$show_result = mysqli_fetch_array($show);
$select = $mod->showInvoiceSales($_SESSION["invoice"]);
$result = mysqli_fetch_array($select);
if (isset($_POST["print"])) {
    Session::unset("invoice");
    Session::unset("customer_name");
    Session::unset("address");
    $mod->checkSupply($result["customer_name"],$result["address"],$result["invoice_no"],$_POST["supplied_by"],$_POST["checked_by"]);
    header("location:wholesales.php");
}
include "includes/header.php";
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
                            <td><?php echo $result["customer_name"]; ?></td>
                            <th>ADDRESS:</th>
                            <td><?php echo $result["address"]; ?></td>
                        </tr>

                        <tr class="odd gradeA">
                            <th>INVOICE NO:</th>
                            <td><?php echo $result["invoice_no"]; ?></td>
                            <th>PAYMENT TYPE:</th>
                            <td><?php echo $result["payment_type"]; ?></td>
                        </tr>

                        <tr class="even gradeA">
                            <th>DATE:</th>
                            <td><?php echo $result["date"]; ?></td>
                            <th>Sold By:</th>
                            <td>Mr/Miss <?php $staff = explode(" ", $result['staff_name']);
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
                $select = $mod->showInvoiceSalesDetails($_SESSION["invoice"]);
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
                    <td style="font-weight: bold;"># <?php echo number_format($result["total"], 2); ?></td>
                </tr>
                <?php

                ?>
                <tr>
                    <td colspan="1"></td>
                    <?php
                    if ($result["old_deposit"] != 0) { ?>
                        <td style="font-weight: bold;">Old Deposit:# <?php echo number_format($result["old_deposit"], 2); ?></td>
                    <?php }
                    ?>

                    <td style="font-weight: bold;">Cash:# <?php echo number_format($result["cash"], 2); ?></td>
                    <td style="font-weight: bold;">Transfer:# <?php echo number_format($result["transfer"], 2); ?></td>
                    <td style="font-weight: bold;">POS:# <?php echo number_format($result["pos"], 2);
                                                            if ($result["pos"] != 0) {
                                                                $select_pos = mysqli_fetch_array($mod->showPos($_SESSION["customer_name"], $_SESSION["address"], $_SESSION["invoice"]));
                                                                echo " (" . $select_pos["pos_type"] . ")";
                                                            }
                                                            ?></td>
                    <td style="font-weight: bold;">Total Payment:</td>
                    <td style="font-weight: bold;"><?php echo number_format($result["deposit"], 2); ?></td>
                </tr>
                <?php

                if ($result["balance"] != 0 or mysqli_num_rows($show) > 0) { ?>
                    <tr>
                        <td colspan="2"></td>
                        <td style="font-weight: bold;">Transport # <?php echo number_format($result["transport"], 2); ?></td>
                        <td style="font-weight: bold;">Old Balance: </td>
                        <td style="font-weight: bold;"># <?php echo number_format($show_result["balance"] - $result["balance"], 2); ?></td>
                        <td style="font-weight: bold;">Total Balance:</td>
                        <td style="font-weight: bold;"># <?php echo number_format($show_result["balance"], 2); ?></td>

                    </tr>
                <?php }
                ?>
                <!-- <tr>
                    <td colspan="5"></td>
                    <td style="font-weight: bold;">Balance:</td>
                    <td style="font-weight: bold;"># <?php echo number_format($result["balance"], 2); ?></td>
                </tr> -->
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
                        $select = $mod->showUser();
                        while ($row = mysqli_fetch_array($select)) { ?>
                            <option value="<?php echo $row['lastname'] ?>">
                                <?php echo 'MR/MISS ' . $row['lastname'] ?>
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
    <script src="bootsrap/jquery.js"></script>
    <script src="bootsrap/popper.js"></script>
    <script src="bootsrap/bootstrap.min.js"></script>


</body>

</html>

<!--Action boxes-->


<!--end-main-container-part-->
<?php

?>