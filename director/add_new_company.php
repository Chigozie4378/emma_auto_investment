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
            <h3 class="card-title text-white">ADD NEW COMPANY</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                    <div class="control-group">
                      <label class="control-label">First Name :</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="companyname" placeholder="Enter Company Name" Required />
                      </div>
                    </div>
                      <div id="danger" class='alert alert-danger text-center' style="display: none;">
                        <strong>Danger!</strong> Company Already Exist.
                      </div>
                    <div class="form-actions">
                      <input type="submit" name="add" class="btn btn-success" value="Add">
                    </div>
                    <div id="success" class='alert alert-success text-center' style="display: none;">
                        <strong>Success!</strong> Company Added Successfully.
                      </div>
                  </form>
                  <?php
                    
                    $ctr->addNewCompany();
                    
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
                  <th>Company Name</th>
                </tr>
              </thead>
              <tbody>
              
                <?php
                $user = new Model();
                $id = 0;
                  $select = $user->showCompany();
                 while ($row = mysqli_fetch_array($select)){?>
                 <tr>
                  <td><?php echo ++$id ?></td>
                  <td><?php echo $row['companyname'] ?></td>
                  <td class="text-center"><a href="edit_company.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a></td>
                  <td class="text-center"><a href="add_new_company.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a></td>
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