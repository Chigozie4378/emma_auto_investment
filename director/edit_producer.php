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
            <h3 class="card-title text-white">EDIT PRODUCER</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                        <input type="hidden" class="form-control" name="id" value="<?php $ctr->producerEdit('id')?>"  />
                            <div class="form-group">
                                <label class="control-label">Distributor :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="distributor" value="<?php $ctr->producerEdit('distributor')?>"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Company :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="company" value="<?php $ctr->producerEdit('company')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Contact :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="contact" value="<?php $ctr->producerEdit('contact')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="email" value="<?php $ctr->producerEdit('email')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                <textarea class="form-control" name="address"><?php $ctr->producerEdit('address')?></textarea>
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
                        $ctr->producerUpdate();
                        ?>

</div>
    </div>
</section>
<?php include "includes/footer.php"; ?>
?>