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
            <h3 class="card-title  text-white">EDIT COMPANY</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                        <input type="hidden" class="form-control" name="id" value="<?php $ctr->companyShow('id')?>"  />
                            <div class="control-group">
                                <label class="control-label">company Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="companyname" value="<?php $ctr->companyShow('companyname')?>"  />
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
                        $ctr->companyUpdate();
                        ?>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<!--end-main-container-part-->
<?php
include "includes/footer.php";
?>