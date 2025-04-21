<?php

include "../../../autoload/loader.php";

$auth_ctr = new AuthController();
$username = $_POST["username"];
$auth_ctr->userBlock($username);
echo "<script>
    setTimeout(function(){
    window.location.href = './add_new_user.php'
    }, 500);
  </script>";
// header("location:../stock.php");
?>
<a class="text-danger" onclick="unblockUser(<?php echo $row['username'] ?>)" data-toggle="tooltip" title="Do you want to Unblock <?php echo $row['firstname'] ?>"><i class="fa fa-lock"></i></a>