<?php 
session_start();
include "core/init.php";

$mod = new Model();
$ctr = new Controller();
?>
<?php
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
?>


<script>
    // function availableStock(sales){
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //         document.getElementById("table").innerHTML = this.responseText;
    //         }
    //     };
    //     xhttp.open("GET", "ajax/load_sales.php?sales="+sales, true);
    //     xhttp.send();
    // }
</script>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Return Goods</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                id="invoice_no" onkeyup="availableInvoiceNo(this.value)" placeholder="Search Invoice No">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                id="address" onkeyup="availableAddress(this.value,getElementById('name').value)" placeholder="Search Address">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right"
                                id="name" onkeyup="availableName(this.value)" placeholder="Search Name">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
              
                    <div class="card-body table-responsive p-0 fixTableHead">
                        <table class="table table-hover">
                        <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Invoice No</th>
                                    <th>Payment Type</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Staff</th>
                                    <th>Date</th>
                                    <th style="text-align:center">View</th>
                                </tr>
                            </thead>
                            <tbody id ="table">
                                <?php 
                  $select = $mod->showReturn();
                 while ($row = mysqli_fetch_array($select)){?>
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
                                        <?php echo $row['invoice_no'] ?>
                                    </td>
                                    <td style="text-transform:uppercase">
                                        <?php echo $row['payment_type'] ?>
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
                                    <td class="text-center"><a href="return_goods_details.php?invoice=<?php echo $row['invoice_no'] ?>"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                </capital>
                                <?php }
                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
  
</section> 
<script>
    function availableName(name){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_all_return_history_name.php?name="+name, true);
        xhttp.send();
    }
    function availableAddress(address,name){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_all_return_history_address.php?address="+address+"&name="+name, true);
        xhttp.send();
    }
    function availableInvoiceNo(invoice_no){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_all_return_history_invoice.php?invoice_no="+invoice_no, true);
        xhttp.send();
    }
</script>
<?php
include "includes/footer.php";
?>