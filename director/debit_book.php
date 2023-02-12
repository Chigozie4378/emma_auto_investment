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
                                    <input type="text" class="form-control" name="customer_name" value="MR "/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="total" onkeyup="depositCalc(this.value,getElementById('deposit').value)" name="total" value="0" onclick="select()"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" id="deposit" name="deposit" onkeyup="totalCalc(getElementById('total').value,this.value)" value="0" onclick="select()" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls" id="balance">
                                    <input type="number" class="form-control" name="balance" onclick="select()"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="date" class="form-control" name="date"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" name="check" class="btn btn-success" value="Check">
                                <?php
                                    $ctr->CheckRecord();
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
                        <input type="hidden" class="form-control" name="id"/>
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="customer_name" value="<?php echo $_SESSION["customer_name"]?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" value="<?php echo $_SESSION["address"]?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="total" onclick="select()" value="<?php echo $_SESSION["total"]?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deposit :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="deposit" onclick="select()" value="<?php echo $_SESSION["deposit"]?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Balance :</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="balance" onclick="select()" value="<?php echo $_SESSION["balance"]?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date :</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="date" value="<?php echo $_SESSION["date"]?>"/>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="comment" value="Record from Debit Book">
                            

                            <div class="form-actions">
                                <input type="submit" name="add" class="btn btn-success" value="Submit">
                            </div>
                            
                    <?php
                    $ctr->addingFromDebitBook();
                    ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function depositCalc(value1, value2) {
        $(document).ready(function() {
            var total = value1;
            var deposit = value2;
            if (total && deposit != "") {
                $.ajax({
                    method: "post",
                    url: "ajax/load_debit_balance.php",
                    data: {
                        total: total,
                        deposit: deposit
                    },
                    success: function(data) {
                        $('#balance').html(data);
                    }
                });
            }

        });
    }

    function totalCalc(value1, value2) {
        $(document).ready(function() {
            var total = value1;
            var deposit = value2;
            if (total && deposit != "") {
                $.ajax({
                    method: "post",
                    url: "ajax/load_debit_balance.php",
                    data: {
                        total: total,
                        deposit: deposit
                    },
                    success: function(data) {
                        $('#balance').html(data)
                    }
                });
            }
        });
    }
</script>
<?php include "includes/footer.php"; ?>