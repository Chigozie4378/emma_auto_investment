<?php
$cash = $_GET["cash"];
$transfer = $_GET["transfer"];
?>
<td colspan="5"></td>
<td>Paid</td>
<td  style="width:15%;text-align:center"><input class="form-control" id="deposit" style="width:100%;box-sizing:border-box" type="number" name="deposit" readonly value="<?php echo $deposit = (int)($cash) + (int)($transfer);?>" onmouseover="this.value,"></td>