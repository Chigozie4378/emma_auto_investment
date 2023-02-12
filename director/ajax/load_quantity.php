<?php
include "../core/init.php";
$model = $_GET['model'];
$productname = $_GET['productname'];
$manufacturer = $_GET['manufacturer'];

?>  
<!--=========== ajax select base on model to manufacture==============-->


    <?php 
    $mod = new Model();
    $select  = $mod->priceProduct($productname,$model,$manufacturer);
    $row = mysqli_fetch_array($select)?>
   
    <input type="hidden" name="qty_db" id="qty_db"  value="<?php echo $row['quantity']?>">
    <input type="number" class="form-control" name="qty" id="qty" onkeyup = "quantity(this.value)" placeholder="<?php echo $row['quantity']?>">
    
   







