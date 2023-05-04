<?php
$total = $_POST["total"];
$deposit = $_POST["deposit"];
$balance = $total - $deposit;


?>
        <input type="text" class="form-control"  name="balance" value="<?php echo $balance; ?>" onclick="select()"/>
   
