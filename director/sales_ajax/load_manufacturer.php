<?php
include "../core/init.php";
$model = $_POST['model'];
$productname = $_POST['productname'];
?>  
<!--=========== ajax select base on product, model to manufacturer==============-->

        <select class="form-control" name="manufacturer" id="manufacturer" onchange="selectManufacturer(this.value,'<?php echo $model?>','<?php echo $productname?>')">
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