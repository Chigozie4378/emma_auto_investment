<?php
include './autoload/loader.php';

$shared = new Shared();
$shared->redirectIfLoggedIn(); // ✅ New line here
$auth_ctr = new AuthController();
$auth_ctr->loginUser();
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
  <link rel="icon" href="./assets/images/logo.jpg" type="image/gif" sizes="20x20">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <style>
     .body{
        background-image: linear-gradient(to bottom,rgba(255, 255, 255,0.6),rgba(0, 0, 0, 0.8)),url('assets/images/background.JPG');
         background-repeat: no-repeat;
         background-size: cover;
         background-position: center;
     }
  </style>
</head>

<body class="hold-transition login-page body">

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="index.php">Staff</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="admin_login.php">Admin</a>
  </li>
  <!-- <li class="nav-item">
    <a class="nav-link" href="manager_login.php">Manager</a>
  </li> -->
  <li class="nav-item">
    <a class="nav-link" href="director_login.php">Director</a>
  </li>
 
</ul>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
        aria-labelledby="custom-tabs-one-home-tab">
        <div class="login-box">
          <div class="login-logo">
            <b>Admin Login</b>
          
          </div>
          <!-- /.login-logo -->
          <div class="card">
            <div class="card-body login-card-body">
            <form name="loginForm" id="loginForm" action="" method="post">
                <div class="input-group mb-3">
                  <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                  <div class="input-group-append">
                    <div class="input-group-text"><span class="fas fa-user"></span></div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                  <div class="input-group-append">
                    <div class="input-group-text"><span class="fas fa-lock"></span></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8"></div>
                  <!-- Hidden field for MAC address -->
                  <input type="hidden" id="mac_address" name="mac_address">
                  <div class="col-4">
                    <button type="button" id="signInButton" class="btn btn-primary btn-block">Sign In</button>
                  </div>
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
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
</body>
</html>
<script src="../js/jquery.min.js"></script>
<script src="../js/matrix.login.js"></script>
<script>
    document.getElementById("signInButton").addEventListener("click", () => {
      const username = document.getElementById("username").value;
      const password = document.getElementById("password").value;

      fetch("http://127.0.0.1:5000/get-mac-address")
        .then(response => response.json())
        .then(data => {
          document.getElementById("mac_address").value = data.mac_address;
          document.getElementById("loginForm").submit();
        })
        .catch(error => {
          console.error("Error fetching MAC address:", error);
          alert("Access Denied! Unauthorized Device.");
        });
    });


  </script>
</body>

</html>