<?php
session_start();
include "core/init.php";
$ctr = new Controller;
$ctr->loginUser();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Emma Auto Investment</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="index.php">Staff</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="admin/admin_login.php">Admin</a>
  </li>
 
</ul>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
        aria-labelledby="custom-tabs-one-home-tab">
        <div class="login-box">
          <div class="login-logo">
            <b>Staff Login</b>
          
          </div>
          <!-- /.login-logo -->
          <div class="card">
            <div class="card-body login-card-body">
              <form action="index.php" method="post">
                <div class="input-group mb-3">
                  <input type="text" name="username" class="form-control" placeholder="Username">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" name="password" class="form-control" placeholder="Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">

                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>

            </div>
            <!-- /.login-card-body -->
          </div>
        </div>
        <!-- /.login-box -->
      </div>
 
    </div>
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/matrix.login.js"></script>
</body>

</html>