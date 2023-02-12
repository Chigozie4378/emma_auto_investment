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
            <h3 class="card-title text-white">ADD NEW PRODUCT</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Name :</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="name" placeholder="Enter Product name" Required />
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">Model :</label>
                 <input type="text" class="form-control" name="model" placeholder="Enter Model">
                </div>
                <div class="form-group">
                  <label class="form-label">Manufacturer :</label>
                  <input type="text" class="form-control" name="manufacturer" placeholder="Enter Manufacturer">
                </div>
                <div class="form-group">
                  <label class="form-label">Quantity :</label>
                  <div class="controls">
                    <input type="number" name="quantity" class="form-control" placeholder="Enter Quantity" Required />
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">Cartoon Price :</label>
                  <div class="controls">
                    <input type="number" name="c_price" class="form-control" placeholder="Enter Price" Required />
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">Wholesale Price :</label>
                  <div class="controls">
                    <input type="number" name="w_price" class="form-control" placeholder="Enter Price" Required />
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">Retail Price :</label>
                  <div class="controls">
                    <input type="number" name="r_price" class="form-control" placeholder="Enter Price" Required />
                  </div>
                </div>
                <div class="card-footer">
                  <div id="danger" class='alert alert-danger text-center' style="display: none;">
                    <strong>Danger!</strong> Product Already Exist.
                  </div>
                  <div class="form-actions">
                    <input type="submit" name="add" class="btn btn-primary" value="Add">
                  </div>
                  <div id="success" class='alert alert-success text-center' style="display: none;">
                    <strong>Success!</strong> Product Added Successfully.
                  </div>

                </div>
            </div>
            </form>
        </div>

        <h5>Products</h5>
        <div id="delete" class='alert alert-success text-center' style="display: none;">
          <strong>Success!</strong> Deleted Successfully.
        </div>

        <?php
                   
                   $ctr->addNewProduct();
                   $ctr->ProductDelete();
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
              <th>Name</th>
              <th>Model</th>
              <th>Manufacturer</th>
              <th>Quantity</th>
              <th>Cartoon Price</th>
              <th>Wholesale Price</th>
              <th>Retail Price</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $select = $mod->showAddProduct();
           while ($row = mysqli_fetch_array($select)){?>
          <tr>
            <td>
              <?php echo ++$id ?>
            </td>
            <td>
              <?php echo $row['name'] ?>
            </td>
            <td>
              <?php echo $row['model'] ?>
            </td>
            <td>
              <?php echo $row['manufacturer'] ?>
            </td>
            <td>
              <?php echo $row['quantity'] ?>
            </td>
            <td>
              <?php echo $row['cprice'] ?>
            </td>
            <td>
              <?php echo $row['wprice'] ?>
            </td>
            <td>
              <?php echo $row['rprice'] ?>
            </td>
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

<?php
include "includes/footer.php";
?>