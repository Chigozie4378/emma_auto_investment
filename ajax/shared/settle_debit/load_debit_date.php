<?php
include "../../../autoload/loader.php";

$ctr = new DebitHistoriesController();
$shared = new Shared();

// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$name = $_GET["name"] ?? "";
$address = $_GET["address"] ?? "";
$date = $_GET["date"] ?? "";
$debits = $ctr->filterDate($date,$name,$address);
while ($row = mysqli_fetch_assoc($debits)) { ?>
    <capital>
        <tr class="clickable-row" , data-href="settle_debit_details.php?customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>">
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
                <?php echo $row['total'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['deposit'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['balance'] ?>
            </td>

            <td style="text-transform:uppercase">
                <?php echo $row['staff_name'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['date'] ?>
            </td>
            <td class="text-center"><a href="edit_debit.php?customer_name=<?= $row['customer_name'] ?>&customer_address=<?php echo $row['address'] ?>">Pay</a></td>


        </tr>
    </capital>
<?php }
?>
