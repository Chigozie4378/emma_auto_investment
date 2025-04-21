
<?php
include '_partial.php';
?>

<?php
include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";

$debit_history_ctr = new DebitHistoriesController();
?>



<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Debit Histories</h3>

                    </div>
              
                    <div class="card-body table-responsive p-0 fixTableHead">
                        <table class="table table-hover">
                        <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name </th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Deposit</th>
                                    <th>Total payment</th>
                                    <th>Balance</th>
                                    <th>Total Balance</th>
                                    <th>Staff</th>
                                    <th>Comments</th>
                                    <th style="width: 10%">Date</th>
                                </tr>
                            </thead>
                            <tbody id ="table">
                                <?php 
                                $customer_name = '';
                                $customer_address = '';
                               $id = 0;
                  $select = $debit_history_ctr->viewDebit();
                 while ($row = mysqli_fetch_assoc($select)){
                    if (!$customer_name) {
                        $customer_name = $row['customer_name'];
                        $customer_address = $row['address']; // Or use 'address' if that's the correct key
                    }
                    ?>
                 <capital>
                 <tr>
                                    <td style="text-transform:uppercase">
                                        <?php echo ++$id ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['customer_name'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['address'] ?>
                                    </td>
                                    
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['total'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['deposit'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['total_paid'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['balance'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['total_balance'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['staff_name'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['comments'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['date'] ?>
                                    </td>
                                    
                                </tr>
                                </capital>
                                <?php }
                ?>
                <thead class=" d-print-none">
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Deposit</th>
                                    <th>Total payment</th>
                                    <th>Balance</th>
                                    <th>Total Balance</th>
                                    <th>Staff</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                </tr>
                        </thead>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <form action="" method="post">
                            <a href="javascript:history.back()" class="btn btn-default">Go Back</a> 

                            <input name="print" type="submit" class="toggle btn btn-success d-print-none" value="print" onclick="printpage()">  
                            <a class="btn btn-primary d-print-none" href="edit_debit.php?customer_name=<?= urlencode($customer_name) ?>&customer_address=<?= urlencode($customer_address) ?>" class="btn btn-success d-print-none">Pay</a>

                           </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
  
</section> 

<script>
         function printpage() {
            window.print() 
        }
    </script>
<?php
include "../includes/shared/footer.php";
?>