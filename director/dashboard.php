<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $_SESSION["directorfullname"] ?> Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">

          <?php
          $select = $mod->countDashboardCustomer();
          $count = mysqli_fetch_array($select);
          ?>
          <div class="inner" style="text-align:center">

            <h3 class="text-white"><?php echo number_format($count['countcustomers']); ?></h3>
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
            <?php
            $select = $mod->showDashboardTotal();
            $total = mysqli_fetch_array($select);
            ?>
            <h3 class="text-white"># <?php echo number_format($total['sumTotal']) ?></h3>
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
            <?php
            $select_credit = $mod->showDashboardCredit();
            $select_transfer = $mod->showDashboardTransfer();
            $select_pos = $mod->showDashboardPos();
            $select_cash = $mod->showDashboardCash();
            $sum_credit = mysqli_fetch_array($select_credit);
            $sum_cash = mysqli_fetch_array($select_cash);
            $sum_transfer = mysqli_fetch_array($select_transfer);
            $sum_pos = mysqli_fetch_array($select_pos);
            ?>
            <h3 class="text-dark"># <?php echo number_format($sum_credit['credit']) ?></h3>

            <p>
              Cash # <?php echo number_format($sum_cash['cash']) ?> <br> Transfer # <?php echo number_format($sum_transfer['transfer']) ?>
               POS # <?php echo number_format($sum_pos['sumPos']) ?>
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
            <?php
            $select = $mod->showDashboardDebit();
            $sum_debit = mysqli_fetch_array($select);
            ?>
            <h3 class="text-white"># <?php echo number_format($sum_debit['balance']) ?></h3>
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
            <th>Payment Type</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Staff</th>
            <th>Date</th>
            <th style="text-align:center">View</th>
          </tr>
        </thead>
        <tbody id="table">
          <?php
          $id = 0;
          $select = $mod->showDashboardSales();
          while ($row = mysqli_fetch_array($select)) { ?>
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
                  <?php echo $row['invoice_no'] ?>
                </td>
                <td style="text-transform:uppercase">
                  <?php echo $row['payment_type'] ?>
                </td>
                <td style="text-transform:uppercase">
                  <?php echo $row['total'] ?>
                </td>
                <td style="text-transform:uppercase">
                  <?php echo $row['deposit'] ?>
                </td>
                <td style="text-transform:uppercase">
                  <?php echo $row['balance'] ?>
                </td>
                <td style="text-transform:uppercase">
                  <?php echo $row['staff_name'] ?>
                </td>
                <td style="text-transform:uppercase">
                  <?php echo $row['date'] ?>
                </td>
                <td class="text-center"><a href="sales_history_details.php?invoice=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>"><i class="fa fa-eye"></i></a>
                </td>
              </tr>
            </capital>
          <?php }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php

include "includes/footer.php";
?>