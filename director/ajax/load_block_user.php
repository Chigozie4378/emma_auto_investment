<?php
 include "../core/init.php";
 $username = $_POST["username"];
 $mod = new Model();
 $mod->blockUser($username);
 echo "<script>
    setTimeout(function(){
    window.location.href = './add_new_user.php'
    }, 500);
  </script>";
// header("location:../stock.php");
?>
<a class="text-danger" onclick="unblockUser(<?php echo $row['username'] ?>)" data-toggle="tooltip" title="Do you want to Unblock <?php echo $row['firstname'] ?>"><i class="fa fa-lock"></i></a> 
