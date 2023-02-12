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
                        <input type="hidden" class="form-control" name="id" value="<?php $ctr->ProductEdit('id')?>"  />
                            <div class="form-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="name" value="<?php echo $ctr->ProductEdit('name')?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Model :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="model" value="<?php echo $ctr->ProductEdit('model')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Manufacturer :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="manufacturer" value="<?php echo $ctr->ProductEdit('manufacturer')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Quantity :</label>
                                <div class="controls">
                                <input type="hidden" class="form-control" name="quantity1" value="<?php echo $ctr->ProductEdit('quantity')?>"/>
                                    <input type="number" class="form-control" name="quantity" value="0" onclick="select()"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Cartoon Price :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="cprice" value="<?php echo $ctr->ProductEdit('cprice')?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Wholesale Price :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="wprice" value="<?php echo $ctr->ProductEdit('wprice')?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Retail Price :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="rprice" value="<?php echo $ctr->ProductEdit('rprice')?>"/>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <input type="submit" name="edit" class="btn btn-success" value="Update">
                            </div>
                            <div id="update" class='alert alert-success text-center' style="display: none;">
                                <strong>Success!</strong> Updated Successfully.
                            </div>
                        </form>
                        <?php
                        $ctr->ProductUpdate();
                        ?>
 </div>
    </div>
</section>
<?php include "includes/footer.php"; ?>
?>