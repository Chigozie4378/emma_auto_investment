<?php
include "../core/init.php";
$model = $_POST['model'];
$productname = $_POST['productname'];
$manufacturer = $_POST['manufacturer'];

?>  
<!--=========== ajax select base on model to manufacture==============-->


<?php 
$mod = new Model();
$select  = $mod->priceProduct($productname,$model,$manufacturer);
$row = mysqli_fetch_array($select)?>
<div class="col-sm-4 pt-1">
    <h6>Unit Price</h6>

</div>
<div class="col-sm-8 pt-1">
    <div id="rpriceDiv">
        <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['id']?>">
        <input type="number" name="price" id="price" class="form-control" value="<?php echo $row['wprice']?>"
            readonly />
    </div>
</div>
<div class="col-sm-4 pt-1">
    <h6>Quantity</h6>
</div>
<div class="col-sm-8 pt-1">

    <div id="demo">
        <input type="hidden" name="qty_db" id="qty_db" value="<?php echo $row['quantity']?>">
        <input type="number" class="form-control" name="qty" id="qty" onkeyup="quantity(this.value)"
            placeholder="<?php echo $row['quantity']?> Available Qty(s) in Store" value="">
    </div>
</div>
