<?php 
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
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
            <h3 class="card-title text-white">ADD NEW PRODUCT</h3>
          </div>
                <form action="add_new_producer.php" method="post" class="form-horizontal">
                <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Supplier :</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="distributor"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Company :</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="company" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact :</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="contact" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email :</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="email" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address :</label>
                            <div class="controls">
                            <textarea name="address" class="form-control" id=""></textarea>
                            </div>
                            
                        </div>
                        <div class="form-actions">
                            <input type="submit" name="add" class="btn btn-success" value="Add">
                        </div>
                        <div id="success" class='alert alert-success text-center' style="display: none;">
                            <strong>Success!</strong> Added Successfully.
                        </div>
                    </div>
                    </form>
                  <?php
                    $ctr->addNewProducer();
                    $ctr->producerDelete();
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
                  <th>SUPPLIER</th>
                  <th>Company</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $id =1;
                  $Producer = new Model();
                  $select = $Producer->showProducer();
                 while ($row = mysqli_fetch_array($select)){?>
                 <tr class="text-center">
                  <td><?php echo $id++ ?></td>
                  <td><?php echo $row['distributor'] ?></td>
                  <td><?php echo $row['company'] ?></td>
                  <td><?php echo $row['contact'] ?></td>
                  <td><?php echo $row['email'] ?></td>
                  <td><?php echo $row['address'] ?></td>
                  <td><a href="edit_producer.php?id=<?php echo $row['id'] ?>"><div class="fa fa-edit"></div></a></td>
                  <td><a href="add_new_producer.php?id=<?php echo $row['id'] ?>"><div class="fa fa-trash text-danger"></div></a></td>
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