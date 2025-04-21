<?php
include "../core/init.php";
error_reporting(E_ERROR);
$productname = $_GET['productname'];
?>  
<!--=========== ajax select base on product name to model ==============-->
        <select class="form-control" name="model" id="model" onmouseout = "selectModel(this.value,'<?php echo $productname?>')">
        <option> select model  </option>
            <?php 
            $mod = new Model();
            $select  = $mod->modelProduct($productname);
            while ($row = mysqli_fetch_array($select)){?>
              <option value="<?php echo $row['model']?>">
                <?php echo ($row['model'])?>
            </option>
            <?php }?>
        </select>


