<?php
$fetch_last_invoice_no = $mod->checkInvoicer();
$get  = mysqli_fetch_array($fetch_last_invoice_no);
$invoice_no_db = $get["invoice_no"];
$add_invoice_no = $invoice_no_db + 1;
$invoice_no3 = ltrim($add_invoice_no, '0');
if (strlen($invoice_no3) == 1) {
    $invoice_no2 =  "0000000" . $add_invoice_no;
} elseif (strlen($invoice_no3) == 2) {
    $invoice_no2 =  "000000" . $add_invoice_no;
} elseif (strlen($invoice_no3) == 3) {
    $invoice_no2 =  "00000" . $add_invoice_no;
} elseif (strlen($invoice_no3) == 4) {
    $invoice_no2 =  "0000" . $add_invoice_no;
} elseif (strlen($invoice_no3) == 5) {
    $invoice_no2 =  "000" . $add_invoice_no;
} elseif (strlen($invoice_no3) == 6) {
    $invoice_no2 =  "00" . $add_invoice_no;
} elseif (strlen($invoice_no3) == 7) {
    $invoice_no2 =  "0" . $add_invoice_no;
} else {
    $invoice_no2 =  $add_invoice_no;
}
