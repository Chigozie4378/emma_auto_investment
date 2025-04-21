<?php
include '../autoload/loader.php';
$shared_ctr = new Shared();
$fullname = $shared_ctr->getFullname();
$role = $shared_ctr->getRole();
$username = $shared_ctr->getUsername();
?>