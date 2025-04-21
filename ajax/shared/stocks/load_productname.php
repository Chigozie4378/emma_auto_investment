<?php
include "../../../autoload/loader.php";

$ctr = new StocksController();
$shared = new Shared();

// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$productname = $_GET["productname"] ?? "";
$select = $ctr->selectProductName($productname);
if (mysqli_num_rows($select) > 0){
while ($row = mysqli_fetch_assoc($select)){?>
<capital>
<tr class="clickable-row" , data-href="edit_product.php?id=<?php echo $row['id'] ?>">
        <td style="text-transform:uppercase">
            <?php echo ++$id ?>
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
        <td class="text-center">
            <a data-toggle="tooltip" title="Do You Want to Delete Product!" href="stock.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a>
        </td>
    </tr>
    </capital>
<?php
}
}else{
    echo "No Result Found";
}
?>
