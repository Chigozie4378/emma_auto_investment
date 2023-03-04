
  <!-- /.navbar -->

  <div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
      <ul class="nav nav-tabs justify-content-center" role="tablist">
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/dashboard.php') {
                                echo "active";
                              } ?>" href="dashboard.php" role="tab">Home <i class="fa fa-home"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/retail.php') {
                                echo "active";
                              } ?>" href="retail.php" role="tab">Retail Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/wholesales.php') {
                                echo "active";
                              } ?>" href="wholesales.php" role="tab">WholeSales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/cartoon.php') {
                                echo "active";
                              } ?>" href="cartoon.php" role="tab">Cartoon Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/deposit.php') {
                                echo "active";
                              } ?>" href="deposit.php" role="tab">Make Deposit</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/sales_history_director.php') {
                                echo "active";
                              } ?>" href="sales_history_director.php" role="tab">Sales History</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/settle_debit.php') {
                                echo "active";
                              } ?>" href="settle_debit.php" role="tab">Settle Debit</a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/debit_history.php') {
                                echo "active";
                              } ?>" href="debit_history.php" role="tab">View Debit History</a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/return_goods.php') {
                                echo "active";
                              } ?>" href="return_goods.php" role="tab">Return Goods</a>
        </li> -->
        <li class="nav-item" style="float:right">
          <a class="nav-link" href="admin_logout.php" role="tab"> Logout <i class="text-warning text-lg fa fa-sign-out-alt"></i></a>
        </li>
    </div>
  </div>
  </ul>
</div>

<!-- /.card -->
</div>
</div>
<!-- /.navbar -->