<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$ctr = new Controller();
$mod = new Model();
$ctr->confirmTransfer();
$mod->export();
?>
 <meta http-equiv="refresh" content="5" />
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <thead>
                            <tr>
                                <th>S/N </th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Invoice No</th>
                                <th>Customer Type</th>
                                <th>Transfer Amount</th>
                                <th>Bank Name</th>
                                <th>Staff Name</th>
                                <th>Status</th>
                                <th>Action</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $select = $mod->showBank();
                            while($row = mysqli_fetch_array($select)){?>
                             <tr>
                                <td><?php echo ++$id?></td>
                                <td><?php echo $row["customer_name"]?></td>
                                <td><?php echo $row["address"]?></td>
                                <td><?php echo $row["invoice_no"];?></td>
                                <td><?php echo $row["customer_type"]?></td>
                                <td><?php echo $row["transfer_amount"]?></td>
                                <td><?php echo $row["bank_name"]?></td>
                                <td><?php echo $row["staff"]?></td>
                                <td><span class="badge badge-warning"><?php echo $row["status"]?></span></td>
                                <td><a class="btn btn-sm btn-success" href="confirm_transfer.php?invoice_no= <?php echo $row['invoice_no']?>&bank_name= <?php echo $row['bank_name']?>">confirm</a></td>
                                
                            </tr>

                          <?php  }
                            ?>
                           
                         
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</section>


<?php include "includes/footer.php"; ?>