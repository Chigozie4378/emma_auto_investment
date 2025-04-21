<?php
include "../core/init.php";
$staffname = $_GET["staffname"];
$mod = new Model();
$select = $mod->selectStaffnameTotal($staffname);
$total = mysqli_fetch_array($select);

$select_credit = $mod->selectStaffnameDeposit($staffname);
$select_transfer = $mod->selectStaffnameTransfer($staffname);
$select_cash = $mod->selectStaffnameCash($staffname);
$select_pos = $mod->selectStaffnamePos($staffname);
$sum_credit = mysqli_fetch_array($select_credit);
$sum_cash = mysqli_fetch_array($select_cash);
$sum_transfer = mysqli_fetch_array($select_transfer);
$sum_pos = mysqli_fetch_array($select_pos);
$select = $mod->selectStaffnameDebit($staffname);
$sum_debit = mysqli_fetch_array($select);
?>
<table class="table table-hover">
    <div class="row d-print-none" style="font-weight:bolder">
        <div class="col-3">Total Sales:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($total['sumTotal'], 2) ?>"></div>
        <div class="col-3">Total Cash:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_cash['cash'], 2) ?>"></div>
        <div class="col-3">Total Transfer:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="Transfer: <?php echo number_format($sum_transfer['transfer'], 2) ?> || Pos: <?php echo number_format($sum_pos['sumPos'], 2) ?>"></div>
        <div class="col-3">Total Debit:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_debit['balance'], 2) ?>"></div>

    </div>
    <thead>
        <tr>
            <th>S/N </th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Payment Type</th>
            <th>Customer Type</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Staff</th>
            <th style="width: 10%;">Date</th>
            <th style="text-align:center">View</th>
        </tr>
    </thead>
    <tbody id="table">
        <?php
        $select = $mod->selectStaffname($staffname);
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
                        <?php echo $row['payment_type'] ?>
                    </td>
                    <td style="text-transform:uppercase">
                        <?php echo $row['customer_type'] ?>
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
<div class="row" style="font-weight:bolder">
    <div class="col-3">Total Sales:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($total['sumTotal'], 2) ?>"></div>
    <div class="col-3">Total Cash:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_cash['cash'], 2) ?>"></div>
    <div class="col-3">Total Transfer:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="Transfer: <?php echo number_format($sum_transfer['transfer'], 2) ?> || Pos: <?php echo number_format($sum_pos['sumPos'], 2) ?>"></div>
    <div class="col-3">Total Debit:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($sum_debit['balance'], 2) ?>"></div>

</div>