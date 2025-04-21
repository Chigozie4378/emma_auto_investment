<?php
include '_partial.php';
$return_goods_histories_ctr = new ReturnGoodsHistoriesController();


include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";

?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Return Goods</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                    id="invoice_no" onkeyup="availableInvoiceNo(this.value)" placeholder="Search Invoice No">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                    id="address" onkeyup="availableAddress(this.value,getElementById('name').value)" placeholder="Search Address">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                    id="name" onkeyup="availableName(this.value)" placeholder="Search Name">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 fixTableHead">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Invoice No</th>
                                    <th>Total</th>
                                    <th>Staff</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?php
                                $id = 0;
                                // $select = $mod->showProduct();
                                $return_goods_histories = $return_goods_histories_ctr->paginateReturnEachGoods();
                                // This is your paginated records
                                $paginationLinks = $return_goods_histories['pagination'];
                                echo $paginationLinks;
                                $select = $return_goods_histories['results'];
                                while ($row = mysqli_fetch_assoc($select)) { ?>
                                    <capital>
                                        <tr class="clickable-row" data-href="return_each_goods_details.php?invoice_no=<?php echo $row['invoice_no'] ?>">
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
                                                <?php echo $row['invoice_no'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['total'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['staff_name'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['date'] ?>
                                            </td>
                                        </tr>
                                    </capital>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            echo $paginationLinks;
                        ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

<script>
    function availableName(name) {
        if (!name.trim()) {
            location.reload()
            return;
        }

        fetch("/emma_auto_investment/ajax/shared/return_each_goods/load_return_goods_name.php?name=" + encodeURIComponent(name))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

    function availableAddress(address, name) {
        if (!address.trim() && !name.trim()) {
            location.reload()
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/return_each_goods/load_return_goods_address.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

    function availableInvoiceNo(invoice_no) {
        if (!invoice_no.trim()) {
            location.reload()
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/return_each_goods/load_return_goods_invoice.php?invoice_no=" + encodeURIComponent(invoice_no))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }
</script>
<?php
include "../includes/shared/footer.php";
?>