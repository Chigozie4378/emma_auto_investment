<?php 
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

$mod = new Model();

?>

<?php
if (isset($_POST["print"])){
    
    header("location:search_record.php");
}
?>
<link rel="stylesheet" href="../assets/datepicker/jquery_ui.css">
<script src="../assets/datepicker/jquery.min.js"></script>


<script>
    function record(date) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sale_record.php?date=" + date, true);
        xhttp.send();
    }
    function findInvoice(date,invoice) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_invoice.php?date="+date+"&invoice="+invoice, true);
   

        xhttp.send();
    }
</script>


</body>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header d-print-none text-center" style="text-align:center">
                        <h2 class="card-title">Sales Record</h2>
                    </div>

                    <div class="card-body">
                        <form class="sticky-top">
                            <div class="form-inline d-print-none">
                              
                                    Date: &nbsp; <input class="form-control" type="text" id="rDate"
                                    placeholder="Click to Search Date" />
                                <input type="hidden">
                                <input type="button" class="form-control bg-success"
                                    onclick="record(document.getElementById('rDate').value)" value="Search">
                                    Invoice No: &nbsp; <input class="form-control" type="text" id="invoice" 
                                    placeholder="Enter Invoice No" />
                                <input type="hidden">
                                <input type="button" class="form-control bg-success"
                                    onclick="findInvoice(document.getElementById('rDate').value,document.getElementById('invoice').value)" value="Search">
                            </div>


                        </form>

                        <div id="table" class="fixTableHead table-responsive">
                            <table class="table table-hover">

                                <thead >

                                    <tr>
                                        <th>S/N</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Invoice No</th>
                                        <th>Payment Type</th>
                                        <th>Customer Type</th>
                                        <th>Total</th>
                                        <th>Cash</th>
                                        <th>Tranfer</th>
                                        <th>POS</th>
                                        <th>Total Paid</th>
                                        <th>Balance</th>
                                        <th>Bank</th>
                                        <th>Staff</th>
                                        <th style="width:10%">Date</th>
                                        <th class="d-print-none" style="text-align:center">View</th>
                                    </tr>
                                </thead>
                                <tbody id="table1">
                                    <?php 
                                    $id = 0;
    $select = $mod->showAllRecordSales();
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
                                                <?php echo $row['cash'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['transfer'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['pos'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['deposit'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['balance'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['bank'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['staff_name'] ?>
                                            </td>
                                            <td style="text-transform:uppercase">
                                                <?php echo $row['date'] ?>
                                            </td>
                                            <td class="d-print-none text-center"><a href="search_record_details.php?invoice=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>"><i class="fa fa-eye"></i></a>
                                            </td>
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
<script>
    $(document).ready(function () {
        $('input[id$=rDate]').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });

    $(".timepicker").datetimepicker({
        icons:
        {
            up: 'fa fa-angle-up',
            down: 'fa fa-angle-down'
        },
        format: 'LT'
    });
</script>
<script>
    function printpage() {
        window.print()
    }
</script>
<?php
include "includes/footer.php";
?>