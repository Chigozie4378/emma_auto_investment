<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();

?>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3"><input type="search" class="form-control" placeholder="Search Product Name" name="search" id="product_name" onkeyup="availableProductName(this.value)"></div>
            <div class="col-sm-3"><input type="search" class="form-control" placeholder="Search Model" name="search" id="model" onkeyup="availableModel(this.value,getElementById('product_name').value)"></div>
            <div class="col-sm-3"><input type="search" class="form-control" placeholder="Search Manufacturer" name="search" id="stock" onkeyup="availableManufacturer(this.value,getElementById('model').value,getElementById('product_name').value)"></div>
            <div class="col-sm-3">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        ADD PRODUCT
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

        <?php $ctr->ProductDelete(); ?>
        <div class="card">
            <div class="card-body">


                <div class="row">
                    <div class="col-md-12 fixTableHead table-responsive">


                        <div id="delete" class='alert alert-success text-center' style="display: none;">
                            <strong>Success!</strong> Deleted Successfully.
                        </div>
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
                                $select = $mod->showProduct();
                                while ($row = mysqli_fetch_array($select)) { ?>
                                    <capital>
                                        <tr>
                                            <td style="text-transform:uppercase">
                                                <?php echo ++$id ?>
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
                                            <td class="text-center"><a data-toggle="tooltip" title="Edit Quantity and Price" href="edit_product.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a></td>
                                            <td class="text-center"><a data-toggle="tooltip" title="Do You Want to Delete Product!" href="stock.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a></td>
                                        </tr>
                                    </capital>
                                <?php }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function availableProductName(productname) {
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_availableProductName.php?productname=" + productname, true);
        xhttp.send();
    }

    function availableModel(model, productname) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_availableModel.php?productname=" + productname + "&model=" + model, true);
        xhttp.send();
    }

    function availableManufacturer(manufacturer, model, productname, ) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_availableManufacturer.php?productname=" + productname + "&manufacturer=" + manufacturer + "&model=" + model, true);
        xhttp.send();
    }
</script>

<!--end-main-container-part-->
<?php
include "includes/footer.php";
?>