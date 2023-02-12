<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();
$ctr->addNewUser();
?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
        <?php echo $ctr->user?>
        <?php echo $ctr->userErr?>
          <div class="card-header">
            <h3 class="card-title text-white">ADD NEW USER</h3>
          </div>
          
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
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
                <h6 id="usernameErr"></h6>
                <div class="controls">
                  <input type="text" class="form-control" onkeyup="checkUsername(this.value)" name="username" placeholder="Enter Username" Required />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Password :</label>
                <div class="controls">
                  <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" Required />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Confirm Password :</label>
                <h6 class="text-danger"><?php echo $ctr->passwordErr ?></h6>
               
                <h6 id="confirm"></h6>
                <div class="controls">
                  <input type="password" name="cpassword" class="form-control" onkeyup="confirmPassword(this.value,getElementById('password').value)" placeholder="Enter to Confirm Password" Required />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Role :</label>
                <div class="controls">
                  <select class="form-control" name="role" id="">
                    <option disabled> Select Role</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="director">Director</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Upload Passport :</label>
                <div class="controls">
                  <input type="file" id="passport" name="passport" class="form-control"/>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" name="add" class="btn btn-success" value="Add">
              </div>
              <?php
              $ctr->userDelete();
              ?>
            </form>
          </div>

        </div>
      </div>
      <div class="col-md-8">
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
                  </tr>
                </thead>
              <tbody>

                <?php
                $id = 0;
                $user = new Model();
                $select = $user->showUser();
                while ($row = mysqli_fetch_array($select)) { ?>
                  <tr>
                    <td><?php echo ++$id ?></td>
                    <td><?php echo $row['firstname'] ?></td>
                    <td><?php echo $row['lastname'] ?></td>
                    <td><?php echo $row['username'] ?></td>
                    <td><?php echo $row['role'] ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td><a data-toggle="tooltip" title="Change Users Details" href="edit_user.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></a></td>
                   

              <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--end-main-container-part-->
<script>
  function confirmPassword(value1,value2){
    $(document).ready(function () {
        $.ajax({
          url: "ajax/load_error.php",
          method: "POST",
          data: {
            password: value1,
            cpassword: value2,
          },
          success: function (data) {
            $("#confirm").html(data);
            
          }
        });
    
    });
  }
  function checkUsername(value1){
    $(document).ready(function () {
        $.ajax({
          url: "ajax/load_username_check.php",
          method: "POST",
          data: {
            username: value1
          },
          success: function (data) {
            $("#usernameErr").html(data);
            
          }
        });
    
    });
  }
  function blockUser(value1){
    $(document).ready(function () {
      
      $.ajax({
          url: "ajax/load_block_user.php",
          method: "POST",
          data: {
            username: value1
          },
          success: function (data) {
            $("#block").html(data);
            reload()
            
          }
        });
    
    });
  }
  function unblockUser(value1){
    $(document).ready(function () {
      $.ajax({
          url: "ajax/load_unblock_user.php",
          method: "POST",
          data: {
            username: value1
          },
          success: function (data) {
            $("#block").html(data);

            reload()
            
          }
        });
    
    });
  }
</script>
<?php
include "includes/footer.php";
?>