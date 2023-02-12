<?php 
 include "../core/init.php";
 $name = $_GET["name"];
 $address = $_GET["address"];
 $date = $_GET["date"];
 $mod = new Model();
$select = $mod->selectAddressDate($name,$address,$date);
while ($row = mysqli_fetch_array($select)){?>
<capital>
        <tr>
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
                <?php echo $row['payment_type'] ?>
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
            <td><a href="sales_history_details.php?invoice=<?php echo $row['invoice_no'] ?>">View</a></td>
        </tr>
        </capital>
        <?php }
?>
