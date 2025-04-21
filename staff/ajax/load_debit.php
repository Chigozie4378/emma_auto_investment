<?php
include "../core/init.php";
$debit = $_GET["debit"];
$mod = new Model();
$select = $mod->selectDebit($debit);
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
            <?php echo $row['balance'] ?>
        </td>
        <td>
            <?php echo $row['date'] ?>
        </td>
        <td><a href="edit_debit.php?id=<?php echo $row['id'] ?>">Edit</a></td>
    </tr> </capital> 
<?php
}
?>
