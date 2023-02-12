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
        <div id="success" class='alert alert-success text-center' style="display: none;">
                        <strong>Success!</strong> User Added Successfully.
                      </div>
          <div class="card-header">
            <h3 class="card-title text-white">ADD NEW USER</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                    <div class="form-group">
                      <label class="control-label">First Name :</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="firstname" placeholder="Enter First name" Required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Last Name :</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="lastname" placeholder="Enter Last name" Required />
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Username :</label>
                        <div class="controls">
                          <input type="text" class="form-control" name="username" placeholder="Enter Username" Required />
                        </div>
                      </div>
                    <div class="form-group">
                      <label class="control-label">Password :</label>
                      <div class="controls">
                        <input type="password" name="password" class="form-control" placeholder="Enter Password"  Required />
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Role :</label>
                        <div class="controls">
                          <select class="form-control" name="role" id="">
                              <option disabled> Select Role</option>
                              <option value="user">Staff</option>
                              <option value="admin">Admin</option>
                              
                          </select>
                        </div>
                      </div>
                      <div id="danger" class='alert alert-danger text-center' style="display: none;">
                        <strong>Danger!</strong> Username Already Exist.
                      </div>
                    <div class="form-actions">
                      <input type="submit" name="add" class="btn btn-success" value="Add">
                    </div>
                    
                  </form>
                  <?php
                    $ctr = new Controller();
                    $ctr->addNewUser();
                    $ctr->userDelete();
                  ?>
</div>
    </div>
</section>
            
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="">All Staffs</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
              <thead>
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Edit</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              
                <?php 
               
                $user = new Model();
                  $select = $user->showUser();
                 while ($row = mysqli_fetch_array($select)){?>
                 <tr>
                  <td><?php echo ++$id ?></td>
                  <td><?php echo $row['firstname'] ?></td>
                  <td><?php echo $row['lastname'] ?></td>
                  <td><?php echo $row['username'] ?></td>
                  <td><?php echo $row['role'] ?></td>
                  <td><?php echo $row['status'] ?></td>
                  <td><a data-toggle="tooltip" title="Edit Quantity and Price" href="edit_user.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></a></td>
                  <td><a class="text-danger" data-toggle="tooltip" title="Do you want to Block <?php echo $row['firstname']?>?" href="add_new_user.php?username=<?php echo $row['username'] ?>"><i class="fa fa-lock"></i></a>
                 || <a class="text-success" data-toggle="tooltip" title="Do you want to Unblock <?php echo $row['firstname']?>?" href="add_new_user.php?username1=<?php echo $row['username'] ?>"><i class="fa fa-unlock"></i></a></td>
                  </tr>
              <?php }
              $ctr->userBlock();
              $ctr->userUnBlock();
                ?>
              
               
              </tbody>
            </table>
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