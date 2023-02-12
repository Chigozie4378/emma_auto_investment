<?php
session_start();

include "core/init.php";

$mod = new Model();
$ctr = new Controller();
?>
<?php
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";


$select = $mod->showDashboardTotal();
$total = mysqli_fetch_array($select);

$select_credit = $mod->showDashboardCredit();
$select_pos = $mod->showDashboardPos();
$select_transfer = $mod->showDashboardTransfer();
$select_cash = $mod->showDashboardCash();
$sum_credit = mysqli_fetch_array($select_credit);
$sum_cash = mysqli_fetch_array($select_cash);
$sum_transfer = mysqli_fetch_array($select_transfer);
$sum_pos = mysqli_fetch_array($select_pos);

$select = $mod->showDashboardDebit();
$sum_debit = mysqli_fetch_array($select);

?>




<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>All Sales of Today (<?php echo date("d-m-Y") ?>) </h3>

                            </div>
                            <div class="col-md-8 d-print-none">
                                <div class="form-inline">
                                    <input type="search" name="search" class="form-control float-right" id="date" onkeyup="staffName(this.value)" placeholder="Search by Staff Name">

                                    <input type="search" name="search" class="form-control float-right" id="name" onkeyup="customerName(this.value)" placeholder="Search Customer Name">
                                    <input type="search" name="search" class="form-control float-right" id="address" onkeyup="customerAddress(this.value,getElementById('name').value)" placeholder="Search Address">
                                </div>
                            </div>
                        </div>
                        <div class=" table-responsive fixTableHead" id="staff">
                            <table class="table table-hover">
                                <div class="row d-print-none" style="font-weight:bolder">
                                    <div class="col-3">Total Sales:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($total['sumTotal'], 2) ?>"></div>
                                    <div class="col-3">Total Cash:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_cash['cash'], 2) ?>"></div>
                                    <div class="col-3">Total Transfer:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="Transfer: <?php echo number_format($sum_transfer['transfer'], 2) ?> || Pos: <?php echo number_format($sum_pos['sumPos'], 2) ?>"></div>
                                    <div class="col-3">Total Debit:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_debit['balance'], 2) ?>"></div>

                                </div>
                                <thead>
                                    <tr>
                                        <th>S/N </th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Payment Type</th>
                                        <th>Customer Type</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Staff</th>
                                        <th style="width: 10%;">Date</th>
                                        <th style="text-align:center">View</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php
                                    $id = 0;
                                    $select = $mod->showInvoiceDate();
                                    while ($row = mysqli_fetch_array($select)) { ?>
                                        <capital>
                                            <tr>
                                                <td style="text-transform:uppercase">
                                                    <?php echo ++$id ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['customer_name'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['address'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['payment_type'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['customer_type'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['total'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['deposit'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['balance'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['staff_name'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['date'] ?>
                                                </td>
                                                <td class="text-center"><a href="sales_history_details.php?invoice=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        </capital>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                            <div class="row" style="font-weight:bolder">
                                <div class="col-3">Total Sales:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($total['sumTotal'], 2) ?>"></div>
                                <div class="col-3">Total Cash:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_cash['cash'], 2) ?>"></div>
                                <div class="col-3">Total Transfer:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="Transfer: <?php echo number_format($sum_transfer['transfer'], 2) ?> || Pos: <?php echo number_format($sum_pos['sumPos'], 2) ?>"></div>
                                <div class="col-3">Total Debit:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_debit['balance'], 2) ?>"></div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<script>
    function customerName(name) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_name.php?name=" + name, true);
        xhttp.send();
    }

    function customerAddress(address, name) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_address.php?address=" + address + "&name=" + name, true);
        xhttp.send();
    }

    function staffName(staffname) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("staff").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_staffname.php?staffname=" + staffname, true);
        xhttp.send();
    }
</script>
<?php
include "includes/footer.php";
?>