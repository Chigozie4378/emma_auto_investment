<?php
include '_partial.php';
$auth_ctr = new AuthController();
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
                        <h3 class="card-title text-white">EDIT USER</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="card-body">
                            <?php if (isset($_GET['updated'])): ?>
                                <div class="alert alert-success text-center">
                                    User updated successfully!
                                </div>
                            <?php endif; ?>
                            <div id="update" class='alert alert-success text-center' style="display: none;">
                                <strong>Success!</strong> Updated Successfully.

                            </div>

                            <input type="hidden" class="form-control" name="id" value="<?php $auth_ctr->userEdit('id') ?>" />
                            <div class="form-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="firstname" value="<?php $auth_ctr->userEdit('firstname') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="lastname" value="<?php $auth_ctr->userEdit('lastname') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Username :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="username" value="<?php $auth_ctr->userEdit('username') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Change Password :</label>
                                <div class="controls">
                                    <input type="text" name="password" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Change Role :</label>
                                <div class="controls">
                                    <select class="form-control" name="role" id="">
                                        <option value="<?php $auth_ctr->userEdit('role') ?>"><?php $auth_ctr->userEdit('role') ?></option>
                                        <option value="admin">Admin</option>
                                        <option value="staff">Staff</option>
                                        <option value="staff">Manager</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Change status :</label>
                                <div class="controls">
                                    <select class="form-control" name="status" id="">
                                        <option value="<?php $auth_ctr->userEdit('status') ?>"><?php $auth_ctr->userEdit('status') ?></option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Change Passport :</label>
                                <div class="controls">
                                    <input type="file" id="passport" name="passport" class="form-control" />
                                </div>
                            </div>

                            <div class="form-action">
                                <a href="./add_new_user.php" class="btn btn-primary">Go Back</a>
                                <input type="submit" name="edit" class="btn btn-success float-right" value="Update">

                            </div>

                    </form>
                    <?php
                    $auth_ctr->userUpdate();
                    ?>


                </div>
            </div>
</section>
<?php
include "../includes/shared/footer.php";
?>