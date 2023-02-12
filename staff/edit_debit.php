<?php 
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
$mod = new Model();
$ctr = new Controller();

?>

<section class="content" >
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="offset-md-3 col-md-6">
        <!-- general form elements -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">EDIT DEBIT</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
          <div class="card-body">
                        <input type="hidden" class="form-control" name="id" value="<?php $ctr->debitEdit('id')?>"  />
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="customer_name" value="<?php echo $ctr->debitEdit('customer_name')?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" value="<?php echo $ctr->debitEdit('address')?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="total" value="<?php echo $ctr->debitEdit('total')?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="deposit" value="<?php echo $ctr->debitEdit('deposit')?>"readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="balance" value="<?php echo $ctr->debitEdit('balance')?>"readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Pay :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="pay" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="date" value="<?php echo date('d-m-Y')?>"readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Comments :</label>
                                <input type="text" class="form-control" name="comment" id="">
                               
                            </div> 
                            
                            <div class="form-actions">
                                <input type="submit" name="update" class="btn btn-success" value="Update">
                            </div>
                            <div id="update" class='alert alert-success text-center' style="display: none;">
                                <strong>Success!</strong> Updated Successfully.
                            </div>
                        </form>
                        <?php
                        $ctr->debitUpdate();
                        ?>
 </div>
    </div>
</section>
<?php include "includes/footer.php"; ?>
?>