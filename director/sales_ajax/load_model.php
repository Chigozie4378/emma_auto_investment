<?php
include "../core/init.php";
$productname = $_POST['productname'];
?>  
<!--=========== ajax select base on product name to model ==============-->
        <select class="form-control"  name="model" id="model" onchange = "selectModel(this.value,'<?php echo $productname?>')">
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


