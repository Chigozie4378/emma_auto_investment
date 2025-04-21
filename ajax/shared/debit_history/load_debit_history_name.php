<?php
include "../../../autoload/loader.php";

$ctr = new DebitHistoriesController();
$shared = new Shared();

// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$name = $_GET["name"] ?? "";
$debit_history = $ctr->showDebitHistoryName($name);
while ($row = mysqli_fetch_array($debit_history)) { ?>
    <capital>
        <tr class="clickable-row" data-href="settle_debit_details.php?customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>">
            <td style="text-transform:uppercase">
                <?php echo ++$id ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['customer_name'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['address'] ?>
            </td>
            <td><?php if ($row['total_balance'] == 0) {
                    echo "SETTLED";
                } else {
                    echo $row['total_balance'];
                }   ?></td>
            <td><?php echo $row['date'] ?></td>

        </tr>
    </capital>
<?php }
?>