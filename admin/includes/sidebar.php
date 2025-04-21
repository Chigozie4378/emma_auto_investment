    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-bold">ADMIN PAGE</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php $mod = new Model;
                      $mod->displayPassport(); ?>" class="img-circle elevation-2">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION["adminfullname"] ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <!-- <li class="nav-item">
              <a href="dashboard.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/admin/dashboard.php') {
                                                        echo "active";
                                                      } ?> ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                 <p>
                    Dashboard
                </p>
             </a>
           </li> -->
            <li class="nav-item">
              <a href="confirm_transfer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/admin/confirm_transfer.php') {
                                                                echo "active";
                                                              } ?>">
                <i class="nav-icon fa fa-paper-plane""></i>
                <p>
                Tranfer Confirmation
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="sales_history.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/admin/sales_history.php') {
                                                            echo "active";
                                                          } ?>">
                <i class="nav-icon fa fa-history"></i>
                <p>
                  Today Sales History
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="search_record.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/admin/search_record.php') {
                                                            echo "active";
                                                          } ?>">
                <i class="nav-icon fa fa-book"></i>
                <p>
                  Sales Record
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link <?php if (($_SERVER['PHP_SELF'] == '/admin/debit_book.php') or ($_SERVER['PHP_SELF'] == '/admin/settle_debit.php') or ($_SERVER['PHP_SELF'] == '/admin/settle_debit_details.php') or ($_SERVER['PHP_SELF'] == '/admin/debit_history.php')) {
                                            echo "active";
                                          } ?>">
                <i class="nav-icon fa fa-credit-card"></i>
                <p>
                  Manage Debit
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="settle_debit.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/admin/settle_debit.php') {
                                                                echo "active";
                                                              } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Settle Debit</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="debit_history.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/admin/debit_history.php') {
                                                                  echo "active";
                                                                } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Debit Histories</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="debit_book.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/admin/debit_book.php') {
                                                              echo "active";
                                                            } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add From Debit Book</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item">
              <a href="add_new_customer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/admin/add_new_customer.php') {
                                                                echo "active";
                                                              } ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Add New Customer
                </p>
              </a>
            </li>




          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">