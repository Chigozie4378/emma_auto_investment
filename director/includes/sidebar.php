    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link text-center">
        <!-- <img src="../assets/dist/img/directorLTELogo.png" alt="directorLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-bold">DIRECTOR PAGE</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php $mod = new Model; $mod->displayPassport();?>" class="img-circle elevation-2">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION["directorfullname"]?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="dashboard.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/dashboard.php'){ echo "active"; } ?> ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                 <p>
                    Dashboard
                </p>
             </a>
           </li>
           
           <!-- <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link  <?php if (($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/wholesale.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/retail.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/cartoon.php')){ echo "active"; } ?>">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                  Sales
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="retail.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/retail.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Retail</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="wholesale.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/wholesale.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>WholeSale</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cartoon.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/cartoon.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cartoon</p>
                  </a>
                </li>

              </ul>
            </li> -->
<!-- 
           <li class="nav-item">
              <a href="sales_history.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/sales_history.php'){ echo "active"; } ?>">
                <i class="nav-icon fa fa-history"></i>
                 <p>
                    Sales History
                </p>
             </a>
           </li> -->
           <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link <?php if (($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/retail.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/wholesale.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/carton.php')){ echo "active"; } ?>">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Sales
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="retail.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/retail.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Retail</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="wholesales.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/wholesales.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>WholeSale</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cartoon.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/cartoon.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cartoon</p>
                  </a>
                </li>
              </ul>
            </li>
           <li class="nav-item">
              <a href="sales_history.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/sales_history.php'){ echo "active"; } ?>">
                <i class="nav-icon fa fa-history"></i>
                 <p>
                   Today Sales History
                </p>
             </a>
         </li>
         <li class="nav-item">
              <a href="search_record.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/search_record.php'){ echo "active"; } ?>">
                <i class="nav-icon fa fa-book"></i>
                 <p>
                    Sales Record
                </p>
             </a>
         </li>
         <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link <?php if (($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/settle_debit.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/debit_history.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/debit_book.php')){ echo "active"; } ?>">
                <i class="nav-icon fa fa-credit-card"></i>
                <p>
                  Manage Debit
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="settle_debit.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/settle_debit.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Settle Debit</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="debit_history.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/debit_history.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Debit Histories</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="debit_book.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/debit_book.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add From Debit Book</p>
                  </a>
                </li>
              </ul>
            </li>
          
           <li class="nav-item">
              <a href="stock.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/stock.php'){ echo "active"; } ?>">
                <i class="nav-icon fa fa-pallet"></i>
                 <p>
                    Manage Stock
                </p>
             </a>
           </li>
           <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link <?php if (($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/return_goods.php') OR ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/return_each_goods.php')){ echo "active"; } ?>">
                <i class="nav-icon fa fa-credit-card"></i>
                <p>
                Returned Goods
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="return_each_goods.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/return_each_goods.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Some Goods Returned</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="return_goods.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/return_goods.php'){ echo "active"; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Goods Returned</p>
                  </a>
                </li>
                
              </ul>
            </li>
            <li class="nav-item">
              <a href="add_new_user.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/add_new_user.php'){ echo "active"; } ?>">
                <i class="nav-icon fas fa-user"></i>
                 <p>
                 Add New Staff
                </p>
             </a>
           </li>
           <li class="nav-item">
              <a href="add_new_product.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/add_new_product.php'){ echo "active"; } ?>">
                <i class="nav-icon fab fa-product-hunt"></i>
                 <p>
                   Add New product
                </p>
             </a>
           </li>
            <li class="nav-item">
              <a href="import.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/import.php'){ echo "active"; } ?>">
               
                <i class="fa fa-file-import"></i>
                 <p>
                    Import
                </p>
             </a>
           </li>
           <!-- <li class="nav-item">
              <a href="purchase.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/purchase.php'){ echo "active"; } ?>">
                <i class="nav-icon fas fa-cart-plus"></i>
                 <p>
                    Purchase
                </p>
             </a>
           </li> -->
           <!-- <li class="nav-item">
              <a href="add_new_producer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/add_new_producer.php'){ echo "active"; } ?>">
                <i class="nav-icon fa fa-user"></i>
                 <p>
                 Add New Producer
                </p>
             </a>
           </li>
           <li class="nav-item">
              <a href="add_new_unit.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/add_new_unit.php'){ echo "active"; } ?>">
                <i class="nav-icon fas fa-motorcycle"></i>
                 <p>
                    Add New Model
                </p>
             </a>
           </li>
           <li class="nav-item">
              <a href="add_new_company.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/add_new_company.php'){ echo "active"; } ?>">
                <i class="nav-icon fas fa-industry"></i>
                 <p>
                    Add New Company
                </p>
             </a>
           </li> -->
           
          
           <li class="nav-item">
              <a href="add_new_customer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/emma_auto_investment/director/add_new_customer.php'){ echo "active"; } ?>">
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
  