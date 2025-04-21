<!-- /.navbar -->

<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs justify-content-center" role="tablist">
      
    <li class="nav-item px-4">
        <a class="nav-brand"><img src="<?php $mod = new Model;
      $mod->displayPassport(); ?>" class="rounded-circle" height='40' width="40"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/dashboard.php') {
                              echo "active";
                            } ?>" href="dashboard.php" role="tab">Home <i class="fa fa-home"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/retail.php') {
                              echo "active";
                            } ?>" href="retail.php" role="tab">Retail Sales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/wholesales.php') {
                              echo "active";
                            } ?>" href="wholesales.php" role="tab">WholeSales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/cartoon.php') {
                              echo "active";
                            } ?>" href="cartoon.php" role="tab">Cartoon Sales</a>
      </li>
      <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/orders.php') {
                                echo "active";
                              } ?>" href="orders.php" role="tab">Orders</a>
        </li>
      <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/deposit.php') {
                                echo "active";
                              } ?>" href="deposit.php" role="tab">Make Deposit</a>
        </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/staff/sales_history.php') {
                              echo "active";
                            } ?>" href="sales_history.php" role="tab">Sales History</a>
      </li>
      <li class="nav-item" style="float:right">
        <a class="nav-link" href="staff_logout.php" role="tab"> Logout <i class="text-warning text-lg fa fa-sign-out-alt"></i></a>
      </li>
  </div>
</div>
</ul>
</div>

<!-- /.card -->
</div>
</div>
<!-- /.navbar -->