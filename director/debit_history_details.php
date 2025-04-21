<?php 
session_start();

include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$ctr = new Controller();
$mod = new Model();
?>
<?php

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
                               $id = 0;
                  $select = $ctr->viewDebit();
                 while ($row = mysqli_fetch_array($select)){?>
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
                            </tbody>
                        </table>
                        <div class="text-center">
                            <form action="" method="post">
                            <input name="print" type="submit" class="toggle btn btn-success d-print-none" value="print" onclick="printpage()">  
                            <a href="./debit_history.php" class="btn btn-primary d-print-none">Go Back</a>
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
include "includes/footer.php";
?>