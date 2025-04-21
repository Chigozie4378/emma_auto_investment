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
    <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['id']?>">
    <input type="number" name="price" id="price" class="form-control" value="<?php echo $row['rprice']?>" 
    onmouseover="loadDoc('<?php echo $productname ?>','<?php echo $model?>','<?php echo $manufacturer ?>')"  readonly/>
   

