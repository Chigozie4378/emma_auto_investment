<?php
include '_partial.php';
$debit_ctr = new DebitController();
$sales_ctr = new SalesController();
?>

<?php
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
                        <h3 class="card-title text-white">PAY DEBT</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div id="update" class='alert alert-success text-center' style="display: none;">
                        <strong>Success!</strong> Updated Successfully.
                    </div>
                    <form action="" method="post" class="form-horizontal">
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="id" value="<?php echo $debit_ctr->editDebit('id') ?>" />
                            <input type="hidden" class="form-control" name="invoice_no" value=" <?= $sales_ctr->generateInvoice() ?>" readonly>
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="customer_name" value="<?php echo $debit_ctr->editDebit('customer_name') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" value="<?php echo $debit_ctr->editDebit('address')  ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="total" value="<?php echo $debit_ctr->editDebit('total')  ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="deposit" value="<?php echo $debit_ctr->editDebit('deposit') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="balance" value="<?php echo $debit_ctr->editDebit('balance') ?>" readonly />
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
                                <input style="width:20px" type="radio" class="form-control" name="payment_type" id="payment_cash" value="cash" />
                                &nbsp;&nbsp;<label for="payment_cash">Cash</label>&nbsp;&nbsp;&nbsp;
                                <input style="width:20px" type="radio" class="form-control" name="payment_type" id="payment_not_cash" value="not_cash" required />
                                &nbsp;&nbsp;<label for="payment_not_cash">Not Cash</label>
                            </div>

                            <div class="form-group" id="date-wrapper">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="text" name="date" id="datepicker" class="form-control" autocomplete="off" required>
                                </div>
                            </div>



                            <input type="hidden" class="form-control" name="comment" id="" value="Deposit Made">
                            <!-- <div class="form-group">
                                <label class="control-label">Comments :</label>
                                
                               
                            </div>  -->

                            <div class="d-flex justify-content-between my-3">
                                <a href="javascript:history.back()" class="btn btn-default">Go Back</a>
                                <input type="submit" name="update" class="btn btn-success" value="Pay">
                            </div>
                    </form>
                    <?php
                    $debit_ctr->debitUpdate();
                    ?>
                </div>
            </div>
</section>
<?php
include "../includes/shared/footer.php";
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const dateWrapper = document.getElementById("date-wrapper");
    const dateInput = document.getElementById("datepicker");
    const radios = document.getElementsByName("payment_type");

    const toggleDateField = () => {
        const selected = Array.from(radios).find(r => r.checked);
        const showDate = selected && selected.value === "not_cash";

        dateWrapper.style.display = showDate ? "block" : "none";
        dateInput.required = showDate;  // ✅ toggle required
    };

    radios.forEach(radio => radio.addEventListener("change", toggleDateField));
    toggleDateField(); // Initial run
});
</script>
