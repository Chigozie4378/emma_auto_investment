<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();

?>
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

                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $records_per_page = 50;
                            $offset = ($page - 1) * $records_per_page;
                            $select = $mod->showProductPagination($offset, $records_per_page);
                            $total_records = $mod->countProduct();
                            $total_pages = ceil($total_records / $records_per_page);

                            // Determine the range of pages to display
                            $range = 5;
                            $start_page = max($page - $range, 1);
                            $end_page = min($page + $range, $total_pages);
                            // Display the pagination links
                            echo '<ul class="pagination">';

                            if ($page > 1) {
                                $prev_page = $page - 1;
                                echo '<li class="page-item"><a class="page-link" href="stock.php?page=1">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="stock.php?page=' . $prev_page . '">Prev</a></li>';
                            }

                            for ($i = $start_page; $i <= $end_page; $i++) {
                                echo '<li class="page-item';
                                if ($i == $page) {
                                    echo ' active';
                                }
                                echo '"><a class="page-link" href="stock.php?page=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($page < $total_pages) {
                                $next_page = $page + 1;
                                echo '<li class="page-item"><a class="page-link" href="stock.php?page=' . $next_page . '">Next</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="stock.php?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                            }

                            echo '</ul>';


                            $id = 0;
                            // $select = $mod->showProduct();
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
                    <?php 
                    // Determine the range of pages to display
                    $range = 5;
                    $start_page = max($page - $range, 1);
                    $end_page = min($page + $range, $total_pages);
                    // Display the pagination links
                    echo '<ul class="pagination">';

                    if ($page > 1) {
                        $prev_page = $page - 1;
                        echo '<li class="page-item"><a class="page-link" href="stock.php?page=1">1</a></li>';
                        echo '<li class="page-item"><a class="page-link" href="stock.php?page=' . $prev_page . '">Prev</a></li>';
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        echo '<li class="page-item';
                        if ($i == $page) {
                            echo ' active';
                        }
                        echo '"><a class="page-link" href="stock.php?page=' . $i . '">' . $i . '</a></li>';
                    }

                    if ($page < $total_pages) {
                        $next_page = $page + 1;
                        echo '<li class="page-item"><a class="page-link" href="stock.php?page=' . $next_page . '">Next</a></li>';
                        echo '<li class="page-item"><a class="page-link" href="stock.php?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                    }

                    echo '</ul>';
                    ?>
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