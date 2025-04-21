<?php
include "../../../autoload/loader.php";

$ctr = new SalesController();
$productname = $_POST['productname'];
$index = $_POST['index'];
?>  
<!--=========== ajax select base on product name to model ==============-->
        <select class="form-control" name="model-input-<?php echo $index?>" id="model" onchange = "selectModel(this.value,'<?php echo $productname?>','<?php echo $index?>')">
        <option> select model  </option>
            <?php 
           
            $select = $ctr->filterModel($productname);
            while ($row = mysqli_fetch_assoc($select)){?>
              <option value="<?php echo $row['model']?>">
                <?php echo ($row['model'])?>
            </option>
            <?php }?>
        </select>


