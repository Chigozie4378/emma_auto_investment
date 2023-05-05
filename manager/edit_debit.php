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
                        <h3 class="card-title text-white">EDIT DEBIT</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div id="update" class='alert alert-success text-center' style="display: none;">
                        <strong>Success!</strong> Updated Successfully.
                    </div>
                    <form action="" method="post" class="form-horizontal">

                        <div class="card-body">
                            <input type="hidden" class="form-control" name="id" value="<?php $ctr->debitEdit('id') ?>" />
                            <input type="hidden" class="form-control" name="invoice_no" value="<?php $ctr->random() ?>" readonly>
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="customer_name" value="<?php echo $ctr->debitEdit('customer_name') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" value="<?php echo $ctr->debitEdit('address') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="total" value="<?php echo $ctr->debitEdit('total') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="deposit" value="<?php echo $ctr->debitEdit('deposit') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="balance" value="<?php echo $ctr->debitEdit('balance') ?>" readonly />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">Pay :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="pay" />
                                </div>
                            </div>
                            <div class="form-inline">
                                <label class="control-label">Choose Payment method :</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input style="width:20px" type="radio" class="form-control" name="payment_type" value="cash"/>&nbsp;&nbsp;<label for="">Cash</label>&nbsp;&nbsp;&nbsp;
                                   <input style="width:20px" type="radio" class="form-control" name="payment_type" value="not_cash"/> &nbsp;&nbsp;<label for="">Non Cash</label>
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="date" class="form-control" name="date" required/>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="comment" id="" value="Deposit Made">
                            <!-- <div class="form-group">
                                <label class="control-label">Comments :</label>
                                
                               
                            </div>  -->

                            <div class="form-actions">
                                <input type="submit" name="update" class="btn btn-success" value="Pay">
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