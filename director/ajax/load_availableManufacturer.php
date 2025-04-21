
<?php
include "../core/init.php";
$productname = $_GET["productname"];
$model = $_GET["model"];
$manufacturer = $_GET["manufacturer"];

$mod = new Model();
$select = $mod->selectManufacturer($productname, $model, $manufacturer);
if (mysqli_num_rows($select) > 0){
    while ($row = mysqli_fetch_array($select)){?>
       <capital>
        <tr>
            <td style="text-transform:uppercase">
                <?php echo ++$mod->id ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['name'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['model'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['manufacturer'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['quantity'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['cprice'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['wprice'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['rprice'] ?>
            </td>
            <td class="text-center"><a data-toggle="tooltip" title="Edit Quantity and Price" href="edit_product.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a></td>
                                    <td class="text-center"><a data-toggle="tooltip" title="Do You Want to Delete Product!" href="stock.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a></td>
        </tr>
        </capital>
       <?php
       }
       

}else{
    echo "no result found";
}
?>