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
            <h3 class="card-title text-white">EDIT CUSTOMER</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                    <div class="form-group">
                      <label class="control-label">Customer Name :</label>
                      <input type="hidden" name="id" value="<?php $ctr->customerEdit("id")?>" >
                      <div class="controls">
                        <input type="text" class="form-control" name="customername" value="<?php $ctr->customerEdit("customer_name")?>" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Address :</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="address" value="<?php $ctr->customerEdit("address")?>" Required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Phone Number:</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="phone_no" value="<?php $ctr->customerEdit("phone_no")?>" Required />
                      </div>
                    </div>
                     
                    <div class="form-actions">
                      <input type="submit" name="update" class="btn btn-success" value="Update">
                    </div>
                    <div id="update" class='alert alert-success text-center' style="display: none;">
                        <strong>Success!</strong> Customer Updated Successfully.
                      </div>
                  </form>
                  <?php
                    
                    $ctr->customerUpdate();
                    
                  ?>
 </div>
    </div>
</section>
<?php include "includes/footer.php"; ?>