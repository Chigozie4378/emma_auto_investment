<?php
include '_partial.php';
$sales_ctr = new SalesHistoriesController();

$sales = $sales_ctr->getTodaySales(); // Today's sales list
$totals = $sales_ctr->getTodayTotals(); // Totals for the day
?>

<?php
include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">

            <!-- Search Inputs (outside #staff div) -->
            <div class="row mb-3 d-print-none">
              <div class="col-md-4">
                <h3>All Sales of Today (<?= date("d-m-Y") ?>)</h3>
              </div>
              <div class="col-md-8">
                <div class="form-inline">
                  <input type="search" class="form-control mr-2" id="date" onkeyup="staffName(this.value)" placeholder="Search by Staff Name">
                  <input type="search" class="form-control mr-2" id="name" onkeyup="customerName(this.value)" placeholder="Search Customer Name">
                  <input type="search" class="form-control" id="address" onkeyup="customerAddress(this.value, document.getElementById('name').value)" placeholder="Search Address">
                </div>
              </div>
            </div>

            <!-- Main Content -->
            <div id="staff">
              <!-- Totals Row -->
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
                  <tbody id="table">
                    <?php $id = 0;
                    while ($row = mysqli_fetch_array($sales)) { ?>
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

                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div> <!-- end of #staff -->

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- JavaScript for AJAX search -->
<script>
  function customerName(name) {
    if (!name.trim()) {
      location.reload()
      return;
    }

    fetch("/emma_auto_investment/ajax/shared/sales_history/load_sales_name.php?name=" + encodeURIComponent(name))
      .then(res => res.text())
      .then(html => {
        document.getElementById("table").innerHTML = html;
        window.bindRowClicks(); 
      });
  }

  function customerAddress(address, name) {
    if (!address.trim() && !name.trim()) {
      location.reload()
      return;
    }
    fetch("/emma_auto_investment/ajax/shared/sales_history/load_sales_address.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name))
      .then(res => res.text())
      .then(html => {
        document.getElementById("table").innerHTML = html;
        window.bindRowClicks(); 
      });
  }

  function staffName(staffname) {
    if (!staffname.trim()) {
      location.reload()
      return;
    }
    fetch("/emma_auto_investment/ajax/shared/sales_history/load_sales_staffname.php?staffname=" + encodeURIComponent(staffname))
      .then(res => res.text())
      .then(html => {
        document.getElementById("staff").innerHTML = html;
        window.bindRowClicks(); 
      });
  }
</script>

<?php include "../includes/shared/footer.php"; ?>