<?php
include "../../../autoload/loader.php";
$ctr = new OrdersController();
$shared = new Shared();
// $username = $_SESSION[$shared->getRole() . "username"] ?? "";
$name = $_GET["name"] ?? "";
$address = $_GET["address"] ?? "";

$orders = $ctr->searchByAddress($name,$address);

$id = 0;
foreach ($orders as $order) { ?>
    <tr style="cursor: pointer;" onclick="window.location='order_details.php?oid=<?php echo $order['order_id'] ?>'">
        <td><?php echo ++$id ?></td>
        <td><?php echo strtoupper($order['name']) ?></td>
        <td><?php echo strtoupper($order['address']) ?></td>
        <td><?php echo $order['total_amount'] ?></td>
        <td><?php echo $order['created_at'] ?></td>
        <td class="text-center">
            <button class="btn btn-danger btn-sm" style="cursor:pointer;" onclick="event.stopPropagation(); cancelOrder('<?php echo $order['order_id'] ?>')">
                <i class="fa fa-times"></i> Cancel
            </button>
        </td>
    </tr>
<?php } ?>