
<?php
include '../helpers/_partial.php';
$sales_ctr = new SalesHistoriesController();
$dashboard_ctr = new DashboardController();
$stats = $dashboard_ctr->getStaffDashboardStats();
$sales = $sales_ctr->getStaff50Sales();


include "../includes/shared/sales/header.php";
include "../includes/shared/sales/head.php";
include "../includes/shared/sales/navbar.php";
?>

<section class="content">
    <div class="container">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner" style="text-align:center">

                        <h3>
                            <?php echo number_format($stats['countcustomers']); ?>
                        </h3>
                        <br>
                        <p>Total Customers For the Day</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="sales_history.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner" style="text-align:center">

                        <h3>#
                            <?php echo number_format($stats['sumTotal']) ?>
                        </h3>
                        <br>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="sales_history.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner" style="text-align:center">
                        <h3 class="text-dark"># <?php echo number_format($stats['credit']) ?></h3>
                        <p>
                            Cash # <?php echo number_format($stats['cash']) ?><br>
                            Transfer # <?php echo number_format($stats['transfer']) ?> ||
                            POS # <?php echo number_format($stats['sumPos']) ?>
                        </p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="sales_history.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner" style="text-align:center">
                       
                        <h3>#
                        <?php echo number_format($stats['balance']) ?>
                        </h3>
                        <br>
                        <p>Total Debit</p>

                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="settle_debit.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<div class="card">
    <div class="card-body">
        <div class="card-body table-responsive p-0 fixTableHead">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>S/N </th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Invoice No</th>
                        <th>Customer Type</th>
                        <th>Payment Type</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
          <?php
          $id = 0;
          while ($row = mysqli_fetch_array($sales)) {
          ?>
            <tr class="clickable-row"
            data-href="sales_history_details.php?invoice_no=<?= $row['invoice_no'] ?>&customer_name=<?= $row['customer_name'] ?>&address=<?= $row['address'] ?>">
              <td><?php echo ++$id ?></td>
              <td><?php echo strtoupper($row['customer_name']) ?></td>
              <td><?php echo strtoupper($row['address']) ?></td>
              <td><?php echo strtoupper($row['invoice_no']) ?></td>
              <td><?php echo strtoupper($row['customer_type']) ?></td>
              <td><?php echo strtoupper($row['payment_type']) ?></td>
              <td><?php echo strtoupper($row['total']) ?></td>
              <td><?php echo strtoupper($row['deposit']) ?></td>
              <td><?php echo strtoupper($row['balance']) ?></td>
              <td><?php echo strtoupper($row['date']) ?></td>
              
            </tr>
          <?php } ?>
        </tbody>
            </table>
        </div>
    </div>
</div>

<?php

include "../includes/shared/sales/footer.php";
?>