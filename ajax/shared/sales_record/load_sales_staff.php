<?php
include "../../../autoload/loader.php";

$ctr = new SalesHistoriesController();
$shared = new Shared();

$date  = $_GET["date"] ?? "";
$staff  = $_GET["staff"] ?? "";
$id = 0;

// If staffname is empty, stop here
if (empty(trim($date))) {
    exit;
}

// Fetch filtered sales by staff name
$sales_record_stat = $ctr->getStaffSalesRecordStats($date, $staff);
?>

<table class="table table-hover">
    <!-- Totals -->
    <div class="row mt-3 d-print-none font-weight-bolder">
        <div class="col-md-3">Total Sales: <input class="form-control" value="<?= number_format($sales_record_stat['total']) ?>"></div>
        <div class="col-md-3">Cash: <input class="form-control" value="<?= number_format($sales_record_stat['cash']) ?>"></div>
        <div class="col-md-3">Transfer / POS:
            <input class="form-control" value="Transfer: <?= number_format($sales_record_stat['transfer']) ?> || POS: <?= number_format($sales_record_stat['pos']) ?>">
        </div>
        <div class="col-md-3">Total Debit: <input class="form-control" value="<?= number_format($sales_record_stat['balance']) ?>"></div>
    </div>
    <thead>

        <tr>
            <th>S/N</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Payment Type</th>
            <th>Customer Type</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Staff</th>
            <th style="width:10%">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select = $ctr->getSalesRecordsByStaff($date,$staff);
        while ($row = mysqli_fetch_assoc($select)) { ?>
            <capital>
                <tr class="clickable-row"
                    data-href="search_record_details.php?invoice_no=<?= $row['invoice_no'] ?>&customer_name=<?= $row['customer_name'] ?>&address=<?= $row['address'] ?>">
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
                </tr>
            </capital>
        <?php }
        ?>
    </tbody>
</table>
<!-- Totals -->
<div class="row mt-3 d-print-none font-weight-bolder">
    <div class="col-md-3">Total Sales: <input class="form-control" value="<?= number_format($sales_record_stat['total']) ?>"></div>
    <div class="col-md-3">Cash: <input class="form-control" value="<?= number_format($sales_record_stat['cash']) ?>"></div>
    <div class="col-md-3">Transfer / POS:
        <input class="form-control" value="Transfer: <?= number_format($sales_record_stat['transfer']) ?> || POS: <?= number_format($sales_record_stat['pos']) ?>">
    </div>
    <div class="col-md-3">Total Debit: <input class="form-control" value="<?= number_format($sales_record_stat['balance']) ?>"></div>
</div>

<p></p>
<div class="text-center">
    <form action="" method="post">
        <input name="print" type="submit" class="toggle btn btn-success d-print-none" value="print" onclick="printpage()">

    </form>
</div>