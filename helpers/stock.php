<?php
include '_partial.php';
$stocks_ctr = new StocksController();


include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";

?>
<style>
/* Force override SweetAlert2 confirm button */
.swal2-confirm.swal-delete-btn {
  background-color: #e3342f !important;
  color: white !important;
  border: none !important;
  box-shadow: none !important;
}

.swal2-confirm.swal-delete-btn:hover {
  background-color: #cc1f1a !important;
}
</style>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-sm-3"><input type="search" class="form-control" placeholder="Search Product Name" name="search" id="product_name" onkeyup="availableProductName(this.value)"></div>
                <div class="col-sm-3"><input type="search" class="form-control" placeholder="Search Model" name="search" id="model" onkeyup="availableModel(this.value,getElementById('product_name').value)"></div>
                <div class="col-sm-3"><input type="search" class="form-control" placeholder="Search Manufacturer" name="search" id="stock" onkeyup="availableManufacturer(this.value,getElementById('model').value,getElementById('product_name').value)"></div>
                <div class="col-sm-3">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bars"></i> PRODUCT MENU
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="add_new_product.php">Add New Product Manually</a>
                            <a class="dropdown-item" href="add_new_excel.php">Add New Product through Excel</a>
                            <a class="dropdown-item" href="update_excel_quantity.php">Update Quantity through Excel</a>
                            <a class="dropdown-item" href="update_price_excel.php">Update Price through Excel</a>

                        </div>
                    </div>
                </div>
            </div>

            <?php $stocks_ctr->ProductDelete(); ?>

            <div id="delete" class='alert alert-success text-center' style="display: none;">
                <strong>Success!</strong> Deleted Successfully.
            </div>
            <div class="card-body">
                <div class="fixTableHead table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>

                                <th>Model</th>
                                <th>Manufacturer</th>
                                <th>Quantity</th>
                                <th>Cartoon Price</th>
                                <th>Wholesale Price</th>
                                <th>Retail Price</th>
                                <th colspan="2" style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                            <?php

                            $id = 1;
                            // $select = $mod->showProduct();
                            $stocks = $stocks_ctr->paginateStocks();
                            // This is your paginated records
                            $paginationLinks = $stocks['pagination'];
                            echo $paginationLinks;
                            $select = $stocks['results'];
                            while ($row = mysqli_fetch_assoc($select)) { ?>
                                <capital>
                                    <tr class="clickable-row" , data-href="edit_product.php?product_id=<?php echo $row['product_id'] ?>">
                                        <td style="text-transform:uppercase">
                                            <?php echo $id++ ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['name'] ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['model'] ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['manufacturer'] ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['quantity'] ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['cprice'] ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['wprice'] ?>
                                        </td>
                                        <td style="text-transform:uppercase">
                                            <?php echo $row['rprice'] ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="verify-delete" data-id="<?php echo $row['product_id']; ?>"><i class="fa fa-trash text-danger"></i></a>
                                        </td>

                                    </tr>
                                </capital>
                            <?php
                            } ?>

                        </tbody>

                    </table>
                    <?php
                    echo $paginationLinks;
                    ?>

                </div>
            </div>
        </div>
    </div>

</section>


<script>
    function availableProductName(productname) {
        if (!productname.trim()) {
            location.reload()
            return;
        }

        fetch("/emma_auto_investment/ajax/shared/stocks/load_productname.php?productname=" + encodeURIComponent(productname))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

    function availableModel(model, productname) {
        if (!model.trim() && !productname.trim()) {
            location.reload()
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/stocks/load_model.php?model=" + encodeURIComponent(model) + "&productname=" + encodeURIComponent(productname))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }

    function availableManufacturer(manufacturer, model, productname) {
        if (!manufacturer.trim() && !model.trim() && !productname.trim()) {
            location.reload()
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/stocks/load_manufacturer.php?manufacturer=" + encodeURIComponent(manufacturer) + "&model=" + encodeURIComponent(model) + "&productname=" + encodeURIComponent(productname))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks();
            });
    }
</script>
<script>
    document.querySelectorAll('.verify-delete').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.id;

            Swal.fire({
                title: 'Enter your password to delete',
                input: 'password',
                inputLabel: 'Password',
                inputPlaceholder: 'Enter your password',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                showCancelButton: true, // ✅ Add cancel button
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                allowEscapeKey: true,
                customClass: {
                    confirmButton: 'swal-delete-btn', // 🔴 style this via CSS
                    cancelButton: 'swal-cancel-btn'
                },
                preConfirm: (password) => {
                    return fetch('<?php echo BASE_URL ?>ajax/shared/users/verify_password.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                password: password,
                                page: 'stock.php'
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message);
                            }
                            return true;
                        })
                        .catch(err => {
                            Swal.showValidationMessage(err.message);
                        });
                }
            }).then(result => {
                if (result.isConfirmed) {
                    // redirect to delete
                    location.href = `stock.php?product_id=${productId}`;
                }
                // Optional: handle cancel
                else if (result.isDismissed) {
                    console.log("User cancelled delete.");
                }
            });

        });
    });
</script>


<!--end-main-container-part-->
<?php
include "../includes/shared/footer.php";
?>