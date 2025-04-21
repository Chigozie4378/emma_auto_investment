<?php
include "../core/init.php";
$name = $_GET["name"];
$address = $_GET["address"];
$mod = new Model();
$select = $mod->selectDebitAddress($name,$address);
while ($row = mysqli_fetch_array($select)){?>
 <capital>   <tr >
        <td>
            <?php echo ++$mod->id ?>
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
            <?php echo $row['balance'] ?>
        </td>
        <td style="text-transform:uppercase">
            <?php echo $row['staff_name'] ?>
        </td>
        <td style="text-transform:uppercase">
            <?php echo $row['date'] ?>
        </td>
        <td class="text-center"><a href="edit_debit.php?id=<?php echo $row['id'] ?>">Pay</a></td>        
        <td class=" text-center"><a href="settle_debit_details.php?customer_name=<?php echo $row['customer_name'] ?>&address=<?php echo $row['address'] ?>"><i class="fa fa-eye text-primary"></i></a></td>


       
        
    </tr> </capital> 
<?php
}
?>
