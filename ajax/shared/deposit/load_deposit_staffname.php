<?php
include "../../../autoload/loader.php";
$ctr = new DepositController();
$shared = new Shared();
// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$staffname = $_GET["staffname"] ?? "";

$deposit = $ctr->searchByStaffName($staffname);
$id = 0;

while ($row = mysqli_fetch_assoc($deposit)) {
?>
  <capital>
    <tr class="clickable-row" , data-href="deposit_details.php?invoice_no=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['customer_address'] ?>">
      <td style="text-transform:uppercase">
        <?php echo ++$id ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['customer_name'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['customer_address'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['invoice_no'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['payment_type'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['cash'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['transfer'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['pos'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['deposit_amount'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['date'] ?>
      </td>
      <td style="text-transform:uppercase">
        <?php echo $row['staff'] ?>
      </td>
    </tr>
  </capital>
<?php } ?>