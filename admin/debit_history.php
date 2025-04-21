

<?php
include '../helpers/_partial.php';
$debit_history_ctr = new DebitHistoriesController();
// $sales_ctr = new SalesController();
// ?>
 <?php
include "../includes/admin/header.php";
include "../includes/admin/navbar.php";
include "../includes/admin/sidebar.php";
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Debit Histories</h3>
                        <!-- 
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                id="date" onkeyup="availableDate(this.value,getElementById('address').value,getElementById('name').value)" placeholder="Search Date">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div> -->
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="address" onkeyup="availableAddress(this.value,getElementById('name').value)" placeholder="Search Address">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="name" onkeyup="availableName(this.value)" placeholder="Search Name">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive fixTableHead">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Balance</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php

                                    $select = $debit_history_ctr->showDebitHistory();
                                    while ($row = mysqli_fetch_array($select)) { ?>
                                        <capital>
                                            <tr class="clickable-row" data-href="settle_debit_details.php?customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>">
                                                <td style="text-transform:uppercase">
                                                    <?php echo ++$id ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['customer_name'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['address'] ?>
                                                </td>
                                                <td><?php if ($row['total_balance'] == 0) {
                                                        echo "SETTLED";
                                                    } else {
                                                        echo $row['total_balance'];
                                                    }   ?></td>
                                                <td><?php echo $row['date'] ?></td>

                                            </tr>
                                        </capital>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

<script>
  function availableName(name) {
    if (!name.trim()) {
      location.reload()
      return;
    }

    fetch("/emma_auto_investment/ajax/shared/debit_history/load_debit_history_name.php?name=" + encodeURIComponent(name))
      .then(res => res.text())
      .then(html => {
        document.getElementById("table").innerHTML = html;
        window.bindRowClicks(); 
      });
  }

  function availableAddress(address, name) {
    if (!address.trim() && !name.trim()) {
      location.reload()
      return;
    }
    fetch("/emma_auto_investment/ajax/shared/debit_history/load_debit_history_address.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name))
      .then(res => res.text())
      .then(html => {
        document.getElementById("table").innerHTML = html;
        window.bindRowClicks(); 
      });
  }

  function availableDate(date, address, name) {
    if (!date.trim() && !address.trim() && !name.trim()) {
      location.reload()
      return;
    }
    fetch("/emma_auto_investment/ajax/shared/debit_history/load_debit_history_date.php?date=" + encodeURIComponent(date) + "&address=" + encodeURIComponent(address)+ "&name=" + encodeURIComponent(name))
      .then(res => res.text())
      .then(html => {
        document.getElementById("table").innerHTML = html;
        window.bindRowClicks(); 
      });
  }
</script>

<?php
include "../includes/admin/footer.php";
?>