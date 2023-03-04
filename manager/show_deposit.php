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




?>




<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Deposits of Customers</h3>

                            </div>
                            <!-- <div class="col-md-8 d-print-none">
                                <div class="form-inline">
                                    <input type="search" name="search" class="form-control float-right" id="date" onkeyup="staffName(this.value)" placeholder="Search by Staff Name">

                                    <input type="search" name="search" class="form-control float-right" id="name" onkeyup="customerName(this.value)" placeholder="Search Customer Name">
                                    <input type="search" name="search" class="form-control float-right" id="address" onkeyup="customerAddress(this.value,getElementById('name').value)" placeholder="Search Address">
                                </div>
                            </div> -->
                        </div>
                        <div class=" table-responsive fixTableHead" id="staff">
                            <table class="table table-hover">
                              
                                <thead>
                                    <tr>
                                        <th>S/N </th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Invoice No</th>
                                        <th>Payment Type</th>
                                        <th>Cash</th>
                                        <th>Transfer</th>
                                        <th>POS</th>
                                        <th>Deposit Amount</th>
                                        <th>Date</th>
                                        <th>Staff</th>
                                        <th style="text-align:center">View</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php
                                    $id = 0;
                                    $select = $mod->showAllDeposit();
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
                                                    <?php echo $row['customer_address'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['invoice_no'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['payment_type'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['cash'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['transfer'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['pos'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['deposit_amount'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['date'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['staff'] ?>
                                                </td>
                                                <td class="text-center"><a href="deposit_details.php?invoice=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['customer_address'] ?>"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        </capital>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<!-- <script>
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
</script> -->
<?php
include "includes/footer.php";
?>