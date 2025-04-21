<?php
include "../core/init.php";
$name = $_GET["name"];
$address = $_GET["address"];
$mod = new Model();
$select = $mod->selectDebitHistoryAddress($name,$address);
while ($row = mysqli_fetch_array($select)){?>
 <capital>   <tr >
        <td>
            <?php echo ++$id ?>
        </td>
        <td>
            <?php echo $row['customer_name'] ?>
        </td>
        <td>
            <?php echo $row['address'] ?>
        </td>
        <td>
            <?php echo $row['total'] ?>
        </td>
        <td>
            <?php echo $row['deposit'] ?>
        </td>
        <td>
            <?php echo $row['total_paid'] ?>
        </td>
        <td>
            <?php echo $row['balance'] ?>
        </td>
        <td>
            <?php echo $row['total_balance'] ?>
        </td>
        <td>
            <?php echo $row['staff_name'] ?>
        </td>
        <td>
            <?php echo $row['date'] ?>
        </td>
        <td style="text-transform:capitalize">
                                        <?php echo $row['comments'] ?>
                                    </td>
        
    </tr> </capital> 
<?php
}
?>
