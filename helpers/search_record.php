<?php
include '_partial.php';
?>

<?php
include "../includes/shared/header.php";
include "../includes/shared/navbar.php";
include "../includes/shared/sidebar.php";
?>


<?php
if (isset($_POST["print"])) {

    header("location:search_record.php");
}
?>



<script>
    function record(date) {
        if (!date.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Field(s)',
                text: 'Please Pick a Date.',
                confirmButtonText: 'OK'
            });
            return;
        }

        fetch("/emma_auto_investment/ajax/shared/sales_record/load_sale_record.php?date=" + encodeURIComponent(date))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks(); 
            });

    }

    function findInvoice(invoice_no) {
        if (!invoice_no.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Field(s)',
                text: 'Invoice Number is required.',
                confirmButtonText: 'OK'
            });
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/sales_record/load_sales_invoice.php?invoice_no=" + encodeURIComponent(invoice_no))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks(); 
            });
    }

    function findStaff(date, staff) {
        if (!date.trim() || !staff.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Field(s)',
                text: 'Please Pick a Date Before Entering Staff Name.',
                confirmButtonText: 'OK'
            });
            return;
        }
        fetch("/emma_auto_investment/ajax/shared/sales_record/load_sales_staff.php?date=" + encodeURIComponent(date) + "&staff=" + encodeURIComponent(staff))
            .then(res => res.text())
            .then(html => {
                document.getElementById("table").innerHTML = html;
                window.bindRowClicks(); 
            });
    }
</script>


</body>

<section class="content">
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

                                Date: &nbsp; <input type="text" name="date" id="datepicker" class="form-control" placeholder="Click to Search Date" autocomplete="off" required>
                                <input type="hidden">
                                <input type="button" class="form-control bg-success" onclick="record(document.getElementById('datepicker').value)" value="Search"> &nbsp;
                                Invoice No: &nbsp; <input class="form-control" type="text" id="invoice" placeholder="Enter Invoice No" />
                                <input type="hidden">
                                <input type="button" class="form-control bg-success" onclick="findInvoice(document.getElementById('invoice').value)" value="Search">&nbsp;
                                Search Staff: &nbsp; <input class="form-control" type="search" id="staff" onkeyup="findStaff(document.getElementById('datepicker').value,this.value)" placeholder="Search a Date before Staff" />
                                <!-- <input type="button" class="form-control bg-success" onclick="findStaff(document.getElementById('datepicker').value,document.getElementById('staff').value)" value="Search"> -->
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
<?php include "../includes/shared/footer.php"; ?>


<script>
    function printpage() {
        window.print()
    }
</script>