<?php 
session_start();

include "core/init.php";

$mod = new Model();
$ctr = new Controller();
?>
<?php
include "includes/header.php";
include "includes/head.php";
include "includes/navbar.php";
?>




<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Goods</h3>
                   

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="address"
                                    onkeyup="customerAddress(this.value,getElementById('name').value,getElementById('username').value)"
                                    placeholder="Search Address">

                            
                                    
                            </div>
                        </div>
                        <div class="card-tools mx-2">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="search" name="search" class="form-control float-right" id="name"
                                    onkeyup="customerName(this.value,getElementById('username').value)" placeholder="Search Customer Name">
                                    
                                    <input type="hidden"  class="form-control float-right" id="username" value="<?php echo $_SESSION['staffusername']?>">
                              
                                    
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 fixTableHead">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S/N </th>
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
                                    <th style="text-align:center">View</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?php 
                  $select = $mod->showInvoice();
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
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<script>
    function customerName(name,username) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_name.php?name=" + name + "&username=" + username, true);
        xhttp.send();
    }
    function customerAddress(address, name,username) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_address.php?address=" + address + "&name=" + name + "&username=" + username, true);
        xhttp.send();
    }
  
</script>
<?php
include "includes/footer.php";
?>