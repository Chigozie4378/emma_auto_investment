<?php
include "../core/init.php";
$mod = new Model();
$title = $_POST["title"];
$name = $_POST["customer_name"];
$customer_name = $title . " " . $name;
$customer_address = $_POST["customer_address"];
$select  = $mod->showDeposit($customer_name, $customer_address);
if (mysqli_num_rows($select) > 0) {
    $row = mysqli_fetch_array($select); ?>
   
        <td colspan="4"></td>
        <td>Old Deposit</td>
        <td colspan="2" style="width:15%;text-align:center"><input class="form-control" style="width:100%;box-sizing:border-box" name = "old_deposit" id="old_deposit" value="<?php echo $row["deposit_amount"];?>" readonly required></td>
        <td></td>
   

    
<?php }else{?>
    <td style="display: none;" colspan="1"></td>
        <td style="display: none;">Transport</td>
        <td style="width:15%;text-align:center;display: none;"><input class="form-control" style="width:100%;box-sizing:border-box" name="old_deposit" id="old_deposit" value="0" required></td>
<?php }
