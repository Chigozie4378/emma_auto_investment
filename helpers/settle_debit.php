
<?php
include '_partial.php';
$debits_ctr = new DebitHistoriesController();
$debits = $debits_ctr->allDebit();


?>

<?php
include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";
?>



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customers Debit</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="date" onkeyup="availableDate(this.value,getElementById('address').value,getElementById('name').value)" placeholder="Search Date">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                        <div class=" table-responsive p-0 fixTableHead">
                            <table class="table table-hover">
                                <thead>
                                    <tr class='sticky'>
                                        <th>S/N</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Deposit</th>

                                        <th>Balance</th>
                                        <th>Staff</th>
                                        <th>Date</th>
                                        <th class="text-center">Pay</th>

                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php
                                    $id = 0;
                                    // $select1 = $mod->showSumTotalDebit();
                                    // $row1 = mysqli_fetch_array($select1);
                                    // print_r($debits);
                                    while ($row = mysqli_fetch_assoc($debits)) { ?>
                                        <capital>
                                            <tr class="clickable-row", data-href="settle_debit_details.php?customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>">
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
                                                <td class="text-center"><a href="edit_debit.php?customer_name=<?= $row['customer_name'] ?>&customer_address=<?php echo $row['address'] ?>">Pay</a></td>
                                               

                                            </tr>
                                        </capital>
                                    <?php }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

<!-- JavaScript for AJAX search -->
<script>
  function availableName(name) {
    if (!name.trim()) {
      location.reload()
      return;
    }

    fetch("/emma_auto_investment/ajax/shared/settle_debit/load_debit_name.php?name=" + encodeURIComponent(name))
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
    fetch("/emma_auto_investment/ajax/shared/settle_debit/load_debit_address.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name))
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
    fetch("/emma_auto_investment/ajax/shared/settle_debit/load_debit_date.php?date=" + encodeURIComponent(date) + "&address=" + encodeURIComponent(address)+ "&name=" + encodeURIComponent(name))
      .then(res => res.text())
      .then(html => {
        document.getElementById("table").innerHTML = html;
        window.bindRowClicks(); 
      });
  }
</script>

<?php
include "../includes/shared/footer.php";
?>