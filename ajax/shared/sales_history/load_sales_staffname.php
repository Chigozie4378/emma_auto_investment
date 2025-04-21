<?php
include "../../../autoload/loader.php";

$ctr = new SalesHistoriesController();
$shared = new Shared();

$staffname = $_GET["staffname"] ?? "";
$id = 0;

// If staffname is empty, stop here
if (empty(trim($staffname))) {
    exit;
}

// Fetch filtered sales by staff name
$sales = $ctr->searchByStaffName($staffname);

// Fetch totals for that staff
$totals = $ctr->getTotalsByStaffName($staffname);
?>

<!-- Totals -->
<div class="row mt-3 d-print-none font-weight-bold">
  <div class="col-md-3">Total Sales: <input class="form-control" value="<?= number_format($totals['sumTotal']) ?>"></div>
  <div class="col-md-3">Cash: <input class="form-control" value="<?= number_format($totals['cash']) ?>"></div>
  <div class="col-md-3">Transfer / POS:
    <input class="form-control" value="Transfer: <?= number_format($totals['transfer']) ?> || POS: <?= number_format($totals['sumPos']) ?>">
  </div>
  <div class="col-md-3">Total Debit: <input class="form-control" value="<?= number_format($totals['balance']) ?>"></div>
</div>

<!-- Table -->
<div class="table-responsive mt-3">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>S/N</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Invoice No</th>
        <th>Payment Type</th>
        <th>Customer Type</th>
        <th>Total</th>
        <th>Paid</th>
        <th>Balance</th>
        <th>Staff</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_array($sales)) { ?>
        <tr class="clickable-row"
        data-href="sales_history_details.php?invoice_no=<?= $row['invoice_no'] ?>&customer_name=<?= $row['customer_name'] ?>&address=<?= $row['address'] ?>">
          <td><?= ++$id ?></td>
          <td><?= strtoupper($row['customer_name']) ?></td>
          <td><?= strtoupper($row['address']) ?></td>
          <td><?= strtoupper($row['invoice_no']) ?></td>
          <td><?= strtoupper($row['payment_type']) ?></td>
          <td><?= strtoupper($row['customer_type']) ?></td>
          <td><?= strtoupper($row['total']) ?></td>
          <td><?= strtoupper($row['deposit']) ?></td>
          <td><?= strtoupper($row['balance']) ?></td>
          <td><?= strtoupper($row['staff_name']) ?></td>
          <td><?= strtoupper($row['date']) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
