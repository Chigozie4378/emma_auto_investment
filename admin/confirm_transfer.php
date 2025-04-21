
<?php
include '../helpers/_partial.php';
// $export = new Export();
// $export->export();

$sales_ctr = new SalesController();
$sales_ctr->confirmTransfer();

$sales_history_ctr = new SalesHistoriesController();
?>

<?php
include "../includes/admin/header.php";
include "../includes/admin/navbar.php";
include "../includes/admin/sidebar.php";
?>
 <meta http-equiv="refresh" content="5" />
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Latest Transfers</h3>

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
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             $id = 0;
                             // $select = $mod->showProduct();
                             $transfers = $sales_history_ctr->paginateTransfer();
                                    // This is your paginated records
                             $paginationLinks = $transfers['pagination'];
                             echo $paginationLinks;
                             $select = $transfers['results']; 
                            while($row = mysqli_fetch_assoc($select)){?>
                             <tr>
                                <td><?php echo ++$id?></td>
                                <td><?php echo $row["customer_name"]?></td>
                                <td><?php echo $row["address"]?></td>
                                <td><?php echo $row["invoice_no"];?></td>
                                <td><?php echo $row["customer_type"]?></td>
                                <td><?php echo $row["transfer_amount"]?></td>
                                <td><?php echo $row["bank_name"]?></td>
                                <td><?php echo $row["staff"]?></td>
                                <td><?php echo $row["date"]?></td>
                                <td><span class="badge badge-warning"><?php echo $row["status"]?></span></td>
                                <td><a class="btn btn-sm btn-success" href="confirm_transfer.php?invoice_no= <?php echo $row['invoice_no']?>&bank_name= <?php echo $row['bank_name']?>">confirm</a></td>
                                
                            </tr>

                          <?php  }
                            ?>
                           
                         
                        </tbody>
                    </table>
                    <?php
                     echo $paginationLinks;
                    ?>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</section>


<?php
include "../includes/shared/footer.php";
?>