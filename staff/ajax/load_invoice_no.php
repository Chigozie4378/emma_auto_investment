<?php
include "../core/init.php";

function generateInvoiceNo()
{
    $mod = new Model();
    $select = $mod->checkInvoicer();
    $row  = mysqli_fetch_array($select);
    $invoice_no_db = $row["invoice_no"];
    $invoice_no2 = $invoice_no_db + 1;
    $invoice_no = ltrim($invoice_no2, '0');
    $zeros = strlen($invoice_no_db) - strlen(ltrim($invoice_no_db, '0'));
    if ($zeros == 0) {
        echo "00000003";
    } else {

        if (strlen($invoice_no) == 1) {
            echo "0000000" . $invoice_no2;
        } elseif (strlen($invoice_no) == 2) {
            echo "000000" . $invoice_no2;
        } elseif (strlen($invoice_no) == 3) {
            echo "00000" . $invoice_no2;
        } elseif (strlen($invoice_no) == 4) {
            echo "0000" . $invoice_no2;
        } elseif (strlen($invoice_no) == 5) {
            echo "000" . $invoice_no2;
        } elseif (strlen($invoice_no) == 6) {
            echo "00" . $invoice_no2;
        } elseif (strlen($invoice_no) == 7) {
            echo "0" . $invoice_no2;
        } else {
            echo $invoice_no2;
        }
    }
}
?>

<input type="text" class="form-control" name="invoice_no" value="<?php generateInvoiceNo() ?>" readonly>