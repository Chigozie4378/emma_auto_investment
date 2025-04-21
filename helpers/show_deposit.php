
<?php
include '_partial.php';
$deposit_ctr = new DepositController();


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
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Deposits of Customers</h3>

                            </div>
                            <div class="col-md-8 d-print-none">
                                <div class="form-inline">
                                    <input type="search" name="search" class="form-control float-right" id="date" onkeyup="staffName(this.value)" placeholder="Search by Staff Name">&nbsp;&nbsp;

                                    <input type="search" name="search" class="form-control float-right" id="name" onkeyup="customerName(this.value)" placeholder="Search Customer Name">&nbsp;&nbsp;
                                    <input type="search" name="search" class="form-control float-right" id="address" onkeyup="customerAddress(this.value,getElementById('name').value)" placeholder="Search Address">
                                </div>
                            </div>
                        </div>
                        <div class=" table-responsive fixTableHead" id="staff">
                            <table class="table table-hover">
                              
                                <thead>
                                    <tr>
                                        <th>S/N </th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Invoice No</th>
                                        <th>Payment Type</th>
                                        <th>Cash</th>
                                        <th>Transfer</th>
                                        <th>POS</th>
                                        <th>Deposit Amount</th>
                                        <th>Date</th>
                                        <th>Staff</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php
                                   $id = 0;
                                   // $select = $mod->showProduct();
                                   $deposit = $deposit_ctr->paginateDeposit();
                                          // This is your paginated records
                                   $paginationLinks = $deposit['pagination'];
                                   echo $paginationLinks;
                                   $select = $deposit['results']; 
                                   while ($row = mysqli_fetch_assoc($select)) { ?>
                                       <capital>
                                           <tr class="clickable-row" , data-href="deposit_details.php?invoice_no=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['customer_address'] ?>">
                                                <td style="text-transform:uppercase">
                                                    <?php echo ++$id ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['customer_name'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['customer_address'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['invoice_no'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['payment_type'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['cash'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['transfer'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['pos'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['deposit_amount'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['date'] ?>
                                                </td>
                                                <td style="text-transform:uppercase">
                                                    <?php echo $row['staff'] ?>
                                                </td>
                                            </tr>
                                        </capital>
                                    <?php }
                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                            <?php echo $paginationLinks;?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->
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

    fetch("/emma_auto_investment/ajax/shared/deposit/load_deposit_name.php?name=" + encodeURIComponent(name))
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
    fetch("/emma_auto_investment/ajax/shared/deposit/load_deposit_address.php?address=" + encodeURIComponent(address) + "&name=" + encodeURIComponent(name))
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
    fetch("/emma_auto_investment/ajax/shared/deposit/load_deposit_staffname.php?staffname=" + encodeURIComponent(staffname))
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