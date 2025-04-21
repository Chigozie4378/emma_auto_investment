<?php
// session_start();

// include "core/init.php";

// $mod = new Model();
// $ctr = new Controller();

// include "includes/sales/header.php";
// include "includes/sales/head.php";
// include "includes/sales/navbar.php";

?>

<?php
include __DIR__ . '/../_partial.php';
$sales_ctr = new SalesHistoriesController();
$shared = new Shared();
$username = $shared->getUsername();
$sales = $sales_ctr->getStaffTodaySales($username); // Today's sales list

include "../includes/shared/sales/header.php";
include "../includes/shared/sales/head.php";
include "../includes/shared/sales/navbar.php";
?>




<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Goods</h3>


                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="address"
                                    onkeyup="customerAddress(this.value,getElementById('name').value,getElementById('username').value)"
                                    placeholder="Search Address">



                            </div>
                        </div>
                        <div class="card-tools mx-2">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="name"
                                    onkeyup="customerName(this.value,getElementById('username').value)" placeholder="Search Customer Name">

                                <input type="hidden" class="form-control float-right" id="username" value="<?php echo $_SESSION['directorusername'] ?>">


                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Invoice No</th>
                                    <th>Payment Type</th>
                                    <th>Customer Type</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Staff</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?php $id = 0;
                                while ($row = mysqli_fetch_array($sales)) { ?>
                                    <tr class="clickable-row"
                                        data-href="sales_history_details.php?invoice_no=<?= $row['invoice_no'] ?>&customer_name=<?= $row['customer_name'] ?>&address=<?= $row['address'] ?>">
                                        <td><?= ++$id ?></td>
                                        <td><?= strtoupper($row['customer_name']) ?></td>
                                        <td><?= strtoupper($row['address']) ?></td>
                                        <td><?= strtoupper($row['invoice_no']) ?></td>
                                        <td><?= strtoupper($row['payment_type']) ?></td>
                                        <td><?= strtoupper($row['customer_type']) ?></td>
                                        <td><?= strtoupper($row['total']) ?></td>
                                        <td><?= strtoupper($row['deposit']) ?></td>
                                        <td><?= strtoupper($row['balance']) ?></td>
                                        <td><?= strtoupper($row['staff_name']) ?></td>
                                        <td><?= strtoupper($row['date']) ?></td>
                                    </tr>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<script>
    function customerName(name, username) {
        if (!name.trim()) {
            location.reload()
            return;
        }

        fetch("/emma_auto_investment/ajax/shared/sales_history/load_sales_name_staff.php?name=" + encodeURIComponent(name) + "&username=" + encodeURIComponent(username))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

    function customerAddress(address, name, username) {
        if (!address.trim() && !name.trim()) {
            location.reload()
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/sales_history/load_sales_address_staff.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name) + "&username=" + encodeURIComponent(username))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }
</script>
<?php
include "../includes/shared/sales/footer.php";
?>