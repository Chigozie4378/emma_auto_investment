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
            <h3 class="card-title text-white">EDIT USER</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                        <input type="hidden" class="form-control" name="id" value="<?php $ctr->userEdit('id')?>"  />
                            <div class="form-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="firstname" value="<?php $ctr->userEdit('firstname')?>"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="lastname" value="<?php $ctr->userEdit('lastname')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Username :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="username" value="<?php $ctr->userEdit('username')?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password :</label>
                                <div class="controls">
                                    <input type="text" name="password" class="form-control"
                                    value="<?php $ctr->userEdit('password')?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Role :</label>
                                <div class="controls">
                                    <select class="form-control" name="role" id="">
                                        <option value="<?php $ctr->userEdit('role')?>"><?php $ctr->userEdit('role')?></option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">status :</label>
                                <div class="controls">
                                    <select class="form-control" name="status" id="">
                                        <option value="<?php $ctr->userEdit('status')?>"><?php $ctr->userEdit('status')?></option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
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
                        $ctr->userUpdate();
                        ?>

  
</div>
    </div>
</section>
<?php include "includes/footer.php"; ?>
?>