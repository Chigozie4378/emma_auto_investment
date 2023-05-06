
<?php 
session_start();

include "core/init.php";
Session::managerAccess("managerusername");
$ctr= new Controller();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">

<link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<link rel="icon" href="../assets/images/logo.jpg" type="image/gif" sizes="20x20">
    <title>Emma Auto And Multi-Services Company</title>
 <style>
     body{
        background-image: linear-gradient(to bottom,rgba(255, 255, 255,0.6),rgba(0, 0, 0, 0.8)),url('../assets/images/background.JPG');
         background-repeat: no-repeat;
         background-size: cover;
         background-position: center;
     }
     form{
         padding-top: 20%;
     }
     img{
         color:white;
     }
 </style>

</head>

<body>

<?php $ctr->updateExcelPrice()?>
<div class="row">
    <div class="offset-4 col-4">
        
    <div class="text-center">
    <h2>Update Product Price by Excel</h2>
                <label for="exampleInputFile"><img width="80px" height="90px" src="../assets/images/file_ulpoad_icon.png" alt=""></label>
            </div>
            <form method="POST" enctype="multipart/form-data">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Uploads</h3>
                    </div>
                    <div class="card-body">
                        <label for="exampleInputPassword1">Select File(s)</label>
                        <input type="file" name="excel" id="select_file" class="form-control">
                    </div>
                    <div class="card-footer">
                        <input  style="float: right;" type="submit" value="Upload" name="upload" id="upload" class="btn btn-primary">
                    </div>

            </form>
           
    </div>
    <div class="text-center">
                <a href="./stock.php" class="btn btn-primary">Go Back</a>
            </div>
</div>




<!-- original pen: https://codepen.io/roydigerhund/pen/ZQdbeN  -->

<!-- NO JS ADDED YET -->

<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.js"></script>

<script src="../assets/dist/js/demo.js"></script>

  <script>



  </script>  
</body>

</html>

<!--Action boxes-->


<!--end-main-container-part-->
