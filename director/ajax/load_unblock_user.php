<?php
 include "../core/init.php";
 $username = $_POST["username"];
 $mod = new Model();
 $mod->unBlockUser($username);
//  header("location:../stock.php");
 echo "<script>
    setTimeout(function(){
    window.location.href = window.location.href
    }, 1000);
  </script>";
?>
<a class="text-success" onclick="blockUser(<?php echo $row['username'] ?>)" data-toggle="tooltip" title="Do you want to Block <?php echo $row['firstname'] ?>"><i class="fa fa-unlock"></i></a> 
