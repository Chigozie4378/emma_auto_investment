<?php
include "../../../autoload/loader.php";

$ctr = new SalesController();
$model = $_POST['model'];
$productname = $_POST['productname'];
$index = $_POST['index'];
?>  
<!--=========== ajax select base on product, model to manufacturer==============-->

        <select class="form-control" name="manufacturer-input-<?php echo $index?>" id="manufacturer" onchange="selectManufacturer(this.value,'<?php echo $model?>','<?php echo $productname?>')">
            <option> Select Product  </option>
            <?php 
            $select  = $ctr->filterManufacturer($productname,$model);
            while ($row = mysqli_fetch_assoc($select)){?>
              <option value="<?php echo $row['manufacturer']?>">
                <?php echo $row['manufacturer']?>
            </option>
            <?php }?>
        </select>