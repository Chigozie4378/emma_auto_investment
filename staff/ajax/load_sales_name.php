<?php 
 include "../core/init.php";
 $customer_name = $_GET["name"];
 $username = $_GET["username"];
 $mod = new Model();
$select = $mod->selectNameSales($customer_name,$username);
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
            <?php echo $row['customer_type'] ?>
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
        <td class="d-print-none text-center"><a href="search_record_details.php?invoice=<?php echo $row['invoice_no'] ?>&customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>"><i class="fa fa-eye"></i></a>
                                                </td>
    </tr>
</capital>
        <?php }
?>