<?php
include '_partial.php';
$debit_ctr = new DebitController();
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
                <div class="card card-primary">
                    <h3 class="card-title text-center">Input Record from Debit Book</h3>
                    <div class="card-body">
                        <div id="success" class='alert alert-success text-center' style="display: none;">
                            <strong>Success!</strong> Updated Successfully.
                        </div>
                        <form action="" method="post">
                            <input type="hidden" class="form-control" name="id" />
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="customer_name" value="MR " />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="total" name="total" value="0" onclick="select()" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" id="deposit" name="deposit" value="0" onclick="select()" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="balance" id="balance" readonly />
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="text" id="datepicker" class="form-control" name="date" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" name="check" class="btn btn-success" value="Check">
                                <?php
                                $debit_ctr->CheckRecord();
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <h3 class="card-title text-center">Please, Confirm what you have before Submitting</h3>
                    <div class="card-body">
                        <div id="success" class='alert alert-success text-center' style="display: none;">
                            <strong>Success!</strong> Updated Successfully.
                        </div>
                        <form action="" method="post">
                            <input type="hidden" class="form-control" name="id" />
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="customer_name" value="<?php echo $_SESSION["customer_name"] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" value="<?php echo $_SESSION["address"] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="total" onclick="select()" value="<?php echo $_SESSION["total"] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="deposit" onclick="select()" value="<?php echo $_SESSION["deposit"] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="balance" onclick="select()" value="<?php echo $_SESSION["balance"] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="text" class="form-control datepicker" name="date" autocomplete="off" value="<?php echo $_SESSION["date"] ?>" />
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="comment" value="Record from Debit Book">

                            <div class="d-flex justify-content-between my-3">
                                <a href="javascript:history.back()" class="btn btn-default">Go Back</a> 
                                <input type="submit" name="add" class="btn btn-success" value="Submit">
                            </div>

                            <?php
                            $debit_ctr->addingFromDebitBook();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function calculateBalance() {
        const total = parseFloat(document.getElementById('total').value) || 0;
        const deposit = parseFloat(document.getElementById('deposit').value) || 0;
        const balance = total - deposit;
        document.getElementById('balance').value = balance;
    }

    // Attach to both fields
    document.addEventListener("DOMContentLoaded", function() {
        const totalInput = document.getElementById("total");
        const depositInput = document.getElementById("deposit");

        totalInput.addEventListener("input", calculateBalance);
        depositInput.addEventListener("input", calculateBalance);
    });
</script>

<?php
include "../includes/shared/footer.php";
?>