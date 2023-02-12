
<?php 
session_start();
include "core/init.php";

$mod = new Model();
$ctr = new Controller();
?>
<?php
include "includes/header.php";
include "includes/navbar.php";
?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Debit Histories</h3>

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
              
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Deposit</th>
                                    
                                    <th>Balance</th>
                                    <th>Staff</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id ="table">
                                <?php 
                  $select = $mod->showDebit();
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
                                    <td><a href="edit_debit.php?id=<?php echo $row['id'] ?>">Pay</a></td>
                                    
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
        xhttp.open("GET", "ajax/load_debit_name.php?name="+name, true);
        xhttp.send();
    }
    function availableAddress(address,name){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_debit_address.php?address="+address+"&name="+name, true);
        xhttp.send();
    }
    function availableDate(date,address,name){
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_debit_date.php?date="+date+"&address="+address+"&name="+name, true);
        xhttp.send();
    }
</script>

<?php
include "includes/footer.php";
?>