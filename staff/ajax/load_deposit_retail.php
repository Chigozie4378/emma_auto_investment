<?php
$total  = (int)$_GET["total"];
$cash = (int)$_GET["cash"];
$transfer = (int)$_GET["transfer"];
$deposit = $cash + $transfer;
$balance = $total - $deposit;
?>
<tr>
    <td colspan="4"></td>
    <td>Paid</td>
    <td colspan="2" style="width:15%;text-align:center"><input class="form-control" name="deposit"
            style="width:100%;box-sizing:border-box" type="number" readonly value="<?php echo $deposit?>"></td>
    <td></td>
</tr>
<tr>
    <td colspan="4"></td>
    <td>Balance</td>
    <td colspan="2" style="width:15%;text-align:center"><input class="form-control"
            style="width:100%;box-sizing:border-box;" type="number" name="balance"
            value="<?php echo $balance ?>" readonly></td>
    <td></td>
</tr>