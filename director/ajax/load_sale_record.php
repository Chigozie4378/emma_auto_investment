<?php
include "../core/init.php";
error_reporting(E_ERROR);
$date  = $_GET["date"];
$mod = new Model();

$result1 = mysqli_fetch_array($mod->showRecordTotal($date));
$result2 = mysqli_fetch_array($mod->showRecordCash($date));
$result3 = mysqli_fetch_array($mod->showRecordTransfer($date));
$result4 = mysqli_fetch_array($mod->showRecordDebit($date));
$result5 = mysqli_fetch_array($mod->showRecordPos($date));
// $select = $mod->showRecord($date);
?>
 <table class="table table-hover">
    <div class="row d-print-none" style="font-weight:bolder">
        <div class="col-3">Total Sales:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($result1["sumTotal"],2)?>"></div>
        <div class="col-3">Total Cash:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($result2["cash"],2)?>"></div>
        <div class="col-3">Total Transfer:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="Transfer: <?php echo number_format($result3["transfer"],2)?> || POS: <?php echo number_format($result5["pos"],2)?>"></div>
        <div class="col-3">Total Debit:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($result4["balance"],2)?>"></div>

    </div>
    <thead>

        <tr>
            <th>S/N</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Payment Type</th>
            <th>Customer Type</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Staff</th>
            <th style="width:10%">Date</th>
            <th class="d-print-none" style="text-align:center">View</th>
        </tr>
    </thead>
    <tbody>
        <?php 
    $select = $mod->showRecordSales($date);
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
            <td class="d-print-none text-center"><a href="search_record_details.php?invoice=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>"><i class="fa fa-eye"></i></a>
                                                </td>
        </tr>
        </capital>
        <?php }
    ?>
    </tbody>
</table>
<div class="row d-print-none" style="font-weight:bolder">
        <div class="col-3">Total Sales:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($result1["sumTotal"],2)?>"></div>
        <div class="col-3">Total Cash:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($result2["cash"],2)?>"></div>
        <div class="col-3">Total Transfer:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="Transfer: <?php echo number_format($result3["transfer"],2)?> || POS: <?php echo number_format($result5["pos"],2)?>"></div>
        <div class="col-3">Total Debit:&nbsp; <input class="form-control" style="font-weight:bolder" type="text" value="<?php echo number_format($result4["balance"],2)?>"></div>

    </div>
    <p></p>
<div class="text-center">
    <form action="" method="post">
    <input name="print" type="submit" class="toggle btn btn-success d-print-none" value="print" onclick="printpage()">

    </form>
</div>