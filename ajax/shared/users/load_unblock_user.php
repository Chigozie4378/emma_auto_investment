<?php


 include "../../../autoload/loader.php";

$auth_ctr = new AuthController();
$username = $_POST["username"];
$auth_ctr->userUnBlock($username);
//  header("location:../stock.php");
 echo "<script>
    setTimeout(function(){
    window.location.href = window.location.href
    }, 1000);
  </script>";
?>
<a class="text-success" onclick="blockUser(<?php echo $row['username'] ?>)" data-toggle="tooltip" title="Do you want to Block <?php echo $row['firstname'] ?>"><i class="fa fa-unlock"></i></a> 
