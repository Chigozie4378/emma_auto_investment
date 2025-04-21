<?php
include __DIR__ . '/../_partial.php';
$orders_ctr = new OrdersController();
$orders = $orders_ctr->orders();
$orders_ctr->cancelOrder();

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
                        <h3 class="card-title">Customer Orders</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="address"
                                    onkeyup="customerAddress(this.value, document.getElementById('name').value, document.getElementById('username').value)"
                                    placeholder="Search Address">
                            </div>
                        </div>
                        <div class="card-tools mx-2">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="name"
                                    onkeyup="customerName(this.value, document.getElementById('username').value)" placeholder="Search Customer Name">
                                <input type="hidden" id="username" value="<?php echo $_SESSION['directorusername'] ?>">
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
                                    <th>Total</th>
                                    <th>Ordered Date</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?php
                                $id = 0;
                                foreach ($orders as $order) { ?>
                                    <tr style="cursor: pointer;" onclick="window.location='order_details.php?oid=<?php echo $order['order_id'] ?>'">
                                        <td><?php echo ++$id ?></td>
                                        <td><?php echo strtoupper($order['name']) ?></td>
                                        <td><?php echo strtoupper($order['address']) ?></td>
                                        <td><?php echo $order['total_amount'] ?></td>
                                        <td><?php echo $order['created_at'] ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm" style="cursor:pointer;" onclick="event.stopPropagation(); cancelOrder('<?php echo $order['order_id'] ?>')">
                                                <i class="fa fa-times"></i> Cancel
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function cancelOrder(orderId) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to cancel this order?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, cancel it!",
            cancelButtonText: "No, keep it"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "orders.php?oidcancel=" + orderId;
            }
        });
    }

    
</script>
<!-- JavaScript for AJAX search -->
<script>
    function customerName(name) {
        if (!name.trim()) {
            location.reload()
            return;
        }

        fetch("/emma_auto_investment/ajax/shared/orders/load_orders_name.php?name=" + encodeURIComponent(name))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

    function customerAddress(address, name) {
        if (!address.trim() && !name.trim()) {
            location.reload()
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/orders/load_orders_address.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

   
</script>

<?php include "../includes/shared/footer.php"; ?>