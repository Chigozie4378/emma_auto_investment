<?php
$path = "/emma_auto_investment/" . $role;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-bold"><?php echo strtoupper($role) ?> PAGE</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php (new Model)->displayPassport(); ?>" class="img-circle elevation-2">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $fullname; ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/dashboard.php") echo "active"; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- <li class="nav-item has-treeview <?php if (preg_match("$path/(retail|wholesales|cartoon)\.php#", $_SERVER['PHP_SELF'])) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if (preg_match("$path/(retail|wholesales|cartoon)\.php#", $_SERVER['PHP_SELF'])) echo 'active'; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="retail.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/retail.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retail</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="wholesales.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/wholesales.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>WholeSale</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cartoon.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/cartoon.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cartoon</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link <?php if (($_SERVER['PHP_SELF'] == "$path/retail.php") or ($_SERVER['PHP_SELF'] == "$path/wholesale.php") or ($_SERVER['PHP_SELF'] == "$path/carton.php")) {
                                                    echo "active";
                                                } ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="retail.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == "$path/retail.php") {
                                                                        echo "active";
                                                                    } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retail</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="wholesales.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == "$path/wholesale.php") {
                                                                            echo "active";
                                                                        } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>WholeSale</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cartoon.php" class="nav-link  <?php if ($_SERVER['PHP_SELF'] == "$path/carton.php") {
                                                                        echo "active";
                                                                    } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cartoon</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="sales_history.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/sales_history.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-history"></i>
                        <p>Today Sales History</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="search_record.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/search_record.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-book"></i>
                        <p>Sales Record</p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php if (preg_match("#$path/(settle_debit|debit_history|debit_book|settle_debit_details)\.php#", $_SERVER['PHP_SELF'])) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if (preg_match("#$path/(settle_debit|debit_history|debit_book|settle_debit_details)\.php#", $_SERVER['PHP_SELF'])) echo 'active'; ?>">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>
                            Manage Debit
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="settle_debit.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/settle_debit.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Settle Debit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="debit_history.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/debit_history.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Debit Histories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="debit_book.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/debit_book.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add From Debit Book</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="stock.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/stock.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-pallet"></i>
                        <p>Manage Stock</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="show_deposit.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/show_deposit.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-money-bill"></i>
                        <p>View Deposit</p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php if (preg_match("#$path/(return_goods|return_each_goods)\.php#", $_SERVER['PHP_SELF'])) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if (preg_match("#$path/(return_goods|return_each_goods)\.php#", $_SERVER['PHP_SELF'])) echo 'active'; ?>">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>
                            Returned Goods
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="return_each_goods.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/return_each_goods.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Some Goods Returned</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="return_goods.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/return_goods.php") echo "active"; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Goods Returned</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="add_new_user.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/add_new_user.php") echo "active"; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Manage Staff</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="add_new_product.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/add_new_product.php") echo "active"; ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>Add New Product</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="add_new_customer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/add_new_customer.php") echo "active"; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Add New Customer</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="bulk_sms.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/bulk_sms.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-envelope"></i>
                        <p>Send Bulk SMS</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="import.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/import.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-file-import"></i>
                        <p>Import</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<div class="content-wrapper">