<?php
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = str_ends_with($basePath, '/helpers') ? './' : '../';



$shared_ctr = new Shared();
$role = $shared_ctr->getRole();
$fullname = $shared_ctr->getFullname();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= $basePath ?>assets/images/logo.jpg" type="image/gif" sizes="20x20">

  <!-- CSS Links -->
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?= $basePath ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">



  <style>
    h3 {
      color: blue;
      font-weight: bolder;
    }
    .sticky {
      position: sticky;
      top: 0px;
    }
    .fixTableHead {
      height: 75vh;
    }
    .fixTableHead thead th {
      position: sticky;
      top: 0;
      background-color: white;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
