<nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#">
            <i class="fas fa-bars"></i>
          </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="dashboard.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
          <a href="admin_logout.php" class="nav-link text-danger">Logout</a>
        </li>

      </ul>

      <marquee style="text-transform:uppercase;font-style: italic; font-weight: bolder;" behavior="" direction="">WELCOME!, <?php echo $_SESSION["managerfullname"]?>. </marquee>
    </nav>
    <!-- /.navbar -->
  <!-- /.navbar -->