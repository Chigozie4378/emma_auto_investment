<?php
include "../core/init.php";
$stock = $_GET["stock"];
$mod = new Model();
$select = $mod->selectStock($stock);
while ($row = mysqli_fetch_array($select)){?>
 <capital>   <tr >
        <td>
            <?php echo ++$id ?>
        </td>
        <td>
            <?php echo $row['name'] ?>
        </td>
        <td>
            <?php echo $row['model'] ?>
        </td>
        <td>
            <?php echo $row['manufacturer'] ?>
        </td>
        <td>
            <?php echo $row['quantity'] ?>
        </td>
        <td>
            <?php echo $row['cprice'] ?>
        </td>
        <td>
            <?php echo $row['wprice'] ?>
        </td>
        <td>
            <?php echo $row['rprice'] ?>
        </td>
        <td class="text-center"><a data-toggle="tooltip" title="Edit Quantity and Price" href="edit_product.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a></td>
                                    <td class="text-center"><a data-toggle="tooltip" title="Do You Want to Delete Product!" href="stock.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a></td>
    </tr> </capital> 
<?php
}
?>
