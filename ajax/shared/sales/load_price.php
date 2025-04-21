<?php
include "../../../autoload/loader.php";

$ctr = new SalesController();
$model = $_POST['model'];
$productname = $_POST['productname'];
$manufacturer = $_POST['manufacturer'];
$price_type = $_POST['price_type'] ?? 'cprice'; // fallback to cprice if not provided

$get_product  = $ctr->getProduct($productname, $model, $manufacturer);
$price_value = $get_product[$price_type] ?? 0;
?>

<div class="col-sm-4 pt-1">
    <h6>Unit Price</h6>
  
</div>
<div class="col-sm-8 pt-1">
    <div id="priceDiv">
        <input type="hidden" name="product_id" id="product_id" value="<?= $get_product['product_id'] ?>">
        <input type="number" name="price" id="price" class="form-control" value="<?= $price_value ?>" readonly>
    </div>
</div>

<div class="col-sm-4 pt-1">
    <h6>Quantity</h6>
</div>
<div class="col-sm-8 pt-1">
    <div id="demo">
        <input type="hidden" name="qty_db" id="qty_db" value="<?= $get_product['quantity'] ?>">
        <input type="number" class="form-control" name="qty" id="qty" onkeyup="quantity(this.value)"
            placeholder="<?= $get_product['quantity'] ?> Available Qty(s) in Store" value="">
    </div>
</div>
