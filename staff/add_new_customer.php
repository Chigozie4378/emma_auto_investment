<?php 
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();
$ctr->customerDelete();
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">ADD NEW CUSTOMER</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                    <div class="form-group">
                      <label class="control-label">Customer Name :</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="customername" placeholder="Enter Customer Name" Required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Address :</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="address" placeholder="Enter Customer Address" Required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Phone Number:</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="phone_no" placeholder="Enter Customer Phone No" Required />
                      </div>
                    </div>
                      <div id="danger" class='alert alert-danger text-center' style="display: none;">
                        <strong>Danger!</strong> Customer Already Exist.
                      </div>
                    <div class="form-actions">
                      <input type="submit" name="add" class="btn btn-success" value="Add">
                    </div>
                    <div id="success" class='alert alert-success text-center' style="display: none;">
                        <strong>Success!</strong> Customer Added Successfully.
                      </div>
                  </form>
                  <?php
                    
                    $ctr->addCustomer();
                    
                  ?>
 </div>
    </div>
</section>
            
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Product Table</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Phone No</th>
                </tr>
              </thead>
              <tbody>
              
                <?php
                $user = new Model();
                  $select = $user->showCustomer();
                 while ($row = mysqli_fetch_array($select)){?>
                 <tr>
                  <td><?php echo ++$id ?></td>
                  <td><?php echo $row['customer_name'] ?></td>
                  <td><?php echo $row['address'] ?></td>
                  <td><?php echo $row['phone_no'] ?></td>
                  <td><a href="edit_customer.php?id=<?php echo $row['id'] ?>">Edit</a></td>
                  <td><a href="add_new_customer.php?id=<?php echo $row['id'] ?>">Delete</a></td>
                  </tr>
              <?php }
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