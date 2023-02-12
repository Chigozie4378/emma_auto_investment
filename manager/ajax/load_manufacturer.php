<?php
include "../core/init.php";
error_reporting(E_ERROR);
$model = $_GET['model'];
$productname = $_GET['productname'];
?>  
<!--=========== ajax select base on product, model to manufacturer==============-->

        <select class="form-control" name="manufacturer" id="manufacturer" onmouseout="selectManufacturer(this.value,'<?php echo $model?>','<?php echo $productname?>')">
            <option> Select Product  </option>
            <?php 
            $mod = new Model();
            $select  = $mod->manufacturerProduct($productname,$model);
            while ($row = mysqli_fetch_array($select)){?>
              <option value="<?php echo $row['manufacturer']?>">
                <?php echo $row['manufacturer']?>
            </option>
            <?php }?>
        </select>