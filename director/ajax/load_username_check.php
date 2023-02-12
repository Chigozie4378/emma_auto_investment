<?php 
 include "../core/init.php";
 $username = $_POST["username"];
 $mod = new Model();
 $user = $mod->newUser($username);
 $count = mysqli_num_rows($user);
 if ($count > 0){
    echo "<i class='text-danger'>Username Already Exist!</i>";
 }