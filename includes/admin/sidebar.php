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
                <!-- <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/dashboard.php") echo "active"; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li> -->

   

                <li class="nav-item">
                    <a href="confirm_transfer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/confirm_transfer.php") echo "active"; ?>">
                        <i class="nav-icon fa fa-exchange" aria-hidden="true"></i>
                        <p>Confirm Transfer</p>
                    </a>
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

                <li class="nav-item has-treeview <?php if (preg_match("#$path/(settle_debit|debit_history|debit_book)\.php#", $_SERVER['PHP_SELF'])) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if (preg_match("#$path/(settle_debit|debit_history|debit_book)\.php#", $_SERVER['PHP_SELF'])) echo 'active'; ?>">
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
                    <a href="add_new_customer.php" class="nav-link <?php if ($_SERVER['PHP_SELF'] == "$path/add_new_customer.php") echo "active"; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Add New Customer</p>
                    </a>
                </li>

             

            </ul>
        </nav>
    </div>
</aside>

<div class="content-wrapper">