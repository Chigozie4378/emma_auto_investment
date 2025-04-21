
<?php
include '../helpers/_partial.php';
$customer_ctr = new CustomerController();

include "../includes/admin/header.php";
include "../includes/admin/navbar.php";
include "../includes/admin/sidebar.php";
$customer_ctr->addCustomer();
$customer_ctr->customerDelete();

?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title text-white">ADD NEW CUSTOMER</h3>
          </div>
          <form action="" method="post" class="form-horizontal">
            <div class="card-body">
              <div class="form-group">
                <label class="control-label">Customer Name :</label>
                <div class="controls">
                  <input type="text" class="form-control" name="customername" value="MR " Required />
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
                  <input type="text" class="form-control" name="phone_no" value="+234" Required />
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
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-8" style="height:90vh; overflow: scroll">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Customers</h3>

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
                  <th colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $id = 0;
                  // $select = $mod->showProduct();
                  $customers = $customer_ctr->paginateCustomer();
                         // This is your paginated records
                  $paginationLinks = $customers['pagination'];
                  echo $paginationLinks;
                  $select = $customers['results']; 
                 while($row = mysqli_fetch_assoc($select)){?>
                  <tr class="clickable-row" data-href="edit_customer.php?customer_id=<?php echo $row['customer_id'] ?>">
                    <td><?php echo ++$id ?></td>
                    <td><?php echo $row['customer_name'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td><?php echo $row['phone_no'] ?></td>
                    <td><a href="add_new_customer.php?customer_id=<?php echo $row['customer_id'] ?>"><i class="fa fa-trash text-danger"></i></a></td>
                  </tr>
                <?php }
                ?>


              </tbody>
            </table>
            <?php
                echo $paginationLinks;
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

   


<!--end-main-container-part-->
<?php
include "../includes/admin/footer.php";
?>