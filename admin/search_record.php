<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

$mod = new Model();

?>

<?php
if (isset($_POST["print"])) {

    header("location:search_record.php");
}
?>
<link rel="stylesheet" href="../assets/datepicker/jquery_ui.css">
<script src="../assets/datepicker/jquery.min.js"></script>


<script>
    function record(date) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sale_record.php?date=" + date, true);
        xhttp.send();
    }

    function findInvoice(date, invoice) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_sales_invoice.php?date=" + date + "&invoice=" + invoice, true);


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

                                Date: &nbsp; <input class="form-control" type="text" id="rDate" placeholder="Click to Search Date" />
                                <input type="hidden">
                                <input type="button" class="form-control bg-success" onclick="record(document.getElementById('rDate').value)" value="Search">
                                Invoice No: &nbsp; <input class="form-control" type="text" id="invoice" placeholder="Enter Invoice No" />
                                <input type="hidden">
                                <input type="button" class="form-control bg-success" onclick="findInvoice(document.getElementById('rDate').value,document.getElementById('invoice').value)" value="Search">
                            </div>


                        </form>

                        <div id="table" class="fixTableHead table-responsive">
                           
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
    $(document).ready(function() {
        $('input[id$=rDate]').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });

    $(".timepicker").datetimepicker({
        icons: {
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