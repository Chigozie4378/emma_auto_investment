<?php
include "../../../autoload/loader.php";
$ctr = new ReturnGoodsHistoriesController();
$shared = new Shared();
// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$name = $_GET["name"] ?? "";

$return_goods = $ctr->searchEachByCustomerName($name);
$id = 0;

while ($row = mysqli_fetch_assoc($return_goods)) {
?>
  <capital>
    <tr class="clickable-row" data-href="return_each_goods_details.php?invoice_no=<?php echo $row['invoice_no'] ?>">
      <td style="text-transform:uppercase">
        <?php echo ++$id ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['customer_name'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['address'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['invoice_no'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['total'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['staff_name'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['date'] ?>
      </td>
    </tr>
  </capital>
<?php } ?>