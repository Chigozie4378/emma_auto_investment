<?php
include '_partial.php';
include "../includes/shared/verify_protected_page.php";
$stocks_ctr = new StocksController();


include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-white">EDIT PRODUCT</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="" method="post" class="form-horizontal">
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="product_id" value="<?php echo $stocks_ctr->ProductEdit('product_id') ?>" />
                            <div class="form-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="name" value="<?php echo $stocks_ctr->ProductEdit('name') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Model :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="model" value="<?php echo $stocks_ctr->ProductEdit('model') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Manufacturer :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="manufacturer" value="<?php echo $stocks_ctr->ProductEdit('manufacturer') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Quantity :</label>
                                <div class="controls">
                                    <input type="hidden" class="form-control" name="quantity1" value="<?php echo $stocks_ctr->ProductEdit('quantity') ?>" />
                                    <input type="text" class="form-control" name="quantity" placeholder="<?php echo $stocks_ctr->ProductEdit('quantity') ?>" onclick="select()" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Cartoon Price :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="cprice" value="<?php echo $stocks_ctr->ProductEdit('cprice') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Wholesale Price :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="wprice" value="<?php echo $stocks_ctr->ProductEdit('wprice') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Retail Price :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="rprice" value="<?php echo $stocks_ctr->ProductEdit('rprice') ?>" />
                                </div>
                            </div>

                            <div class="d-flex justify-content-between my-3">
                                <a href="javascript:history.back()" class="btn btn-default">Go Back</a>
                                <input type="submit" name="edit" class="btn btn-success" value="Update">
                            </div>
                            <div id="update" class='alert alert-success text-center' style="display: none;">
                                <strong>Success!</strong> Updated Successfully.
                            </div>
                    </form>
                    <?php
                    $stocks_ctr->ProductUpdate();
                    ?>
                </div>
            </div>
</section>
<?php
include "../includes/shared/footer.php";
?>