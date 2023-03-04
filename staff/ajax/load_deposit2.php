<?php
$cash = (int)$_GET["cash"];
$transfer = (int)$_GET["transfer"];
$pos = (int)$_GET["pos"];
$deposit = $cash + $transfer +$pos;

?>
<input type="number" name="deposit_amount" id="deposit_amount" class="form-control" value="<?php echo $deposit;?>" readonly>