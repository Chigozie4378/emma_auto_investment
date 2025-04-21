<?php
include "../../../autoload/loader.php";
$ctr = new SalesHistoriesController();
$shared = new Shared();
// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$name = $_GET["name"] ?? "";

$sales = $ctr->searchByCustomerName($name);
$id = 0;

while ($row = mysqli_fetch_assoc($sales)) {
?>
  <tr class="clickable-row"
    data-href="sales_history_details.php?invoice_no=<?= $row['invoice_no'] ?>&customer_name=<?= $row['customer_name'] ?>&address=<?= $row['address'] ?>">
    <td><?= ++$id ?></td>
    <td><?= strtoupper($row['customer_name']) ?></td>
    <td><?= strtoupper($row['address']) ?></td>
    <td><?= strtoupper($row['invoice_no']) ?></td>
    <td><?= strtoupper($row['payment_type']) ?></td>
    <td><?= strtoupper($row['customer_type']) ?></td>
    <td><?= strtoupper($row['cash']) ?></td>
    <td><?= strtoupper($row['transfer']) ?></td>
    <td><?= strtoupper($row['pos']) ?></td>
    <td><?= strtoupper($row['total']) ?></td>
    <td><?= strtoupper($row['deposit']) ?></td>
    <td><?= strtoupper($row['balance']) ?></td>
    <td><?= strtoupper($row['bank']) ?></td>
    <td><?= strtoupper($row['staff_name']) ?></td>
    <td><?= strtoupper($row['date']) ?></td>

  </tr>
<?php } ?>