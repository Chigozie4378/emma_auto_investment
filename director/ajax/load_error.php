<?php

use Mpdf\Tag\P;

$password = $_POST["password"];
$cpassword = $_POST["cpassword"];
if ($password != $cpassword){
    echo "<i class='text-danger'>Password Not Matched!</i>";
}else{
    echo "<i class='text-success'>Password Matched!</i>";
}