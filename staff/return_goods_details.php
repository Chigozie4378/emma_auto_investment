<?php 
session_start();

include "core/init.php";
Session::staffAccess('staffusername');
?>
<?php 
$ctr= new Controller();
if (isset($_POST["print"])){
    
    header("location:sales_history.php");
}

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
    <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <table class="table table-striped table-light table-bordered">
                    <tr class="odd gradeX">
                    <th>NAME:    </th>
                    <td><?php echo $ctr->viewReturnDetail("customer_name");?></td>
                    <th>ADDRESS:</th>
                    <td><?php  $ctr->viewReturnDetail("address");?></td>
                    
                    
                </tr>
               
                <tr class="odd gradeA">
                    <th>INVOICE NO:</th>
                    <td><?php $ctr->viewReturnDetail("invoice_no");?></td>
                    <th>PAYMENT TYPE:</th>
                    <td><?php $ctr->viewReturnDetail("payment_type");?></td>
                </tr>
                
                <tr class="even gradeA">
                    <th>DATE:</th>
                    <td><?php $ctr->viewReturnDetail("date");?></td>
                    <td colspan="2"></td>
                </tr>
                    
                </table>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-light table-bordered">
                   <tr>
                       <th>S/N</th>
                       <th>Qty</th>
                       <th>Item</th>
                       <th>Model</th>
                       <th>Manufacturer</th>
                       <th>Price</th>
                       <th>Amount</th>
                     
                   </tr>
                  <?php 
                  
                  $result = $ctr->viewReturnDetails();
                  while ($row = mysqli_fetch_array($result)){?>

                   <tr>
                       <td><?php echo ++$id?></td>
                       <td><?php echo $row["quantity"]?></td>
                       <td><?php echo $row["product_name"]?></td>
                       <td><?php echo $row["model"]?></td>
                       <td><?php echo $row["manufacturer"]?></td>
                       <td><?php echo $row["price"]?></td>
                       <td><?php echo $row["amount"]?></td>
                      
                   </tr> 
                   <?php
                    }
                   ?>
                   <tr>
                       <td colspan="5"></td>
                       <td style="font-weight: bold;">Total Amount:</td>
                       <td style="font-weight: bold;"><?php $ctr->viewReturnDetail("total");?></td>
                   </tr>
                   <tr>
                    <td colspan="3"></td>
                    <td style="font-weight: bold;">Cash:<?php $ctr->viewReturnDetail("cash");?></td>
                    
                    <td style="font-weight: bold;">Transfer:<?php $ctr->viewReturnDetail("transfer");?></td>
                    <td style="font-weight: bold;">Total Paid:</td>
                    <td style="font-weight: bold;"><?php $ctr->viewReturnDetail("deposit");?></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="font-weight: bold;">Balance:</td>
                    <td style="font-weight: bold;"><?php $ctr->viewReturnDetail("balance");?></td>
                </tr>
                </table>
                
            </div>
        </div>
        <div class="row">
            <div class="col-6">
               
               <div class="form-inline" >
                <label for="email">Customer Signature:</label>
                <input type="text" class="form-control" id="email">
              
                
               </div>
            </div>
            <div class="col-6">
               
                <div class="form-inline" style="float: right;">
                 <label  for="pwd">Manager Signature:</label>
                 <input type="text" class="form-control" id="pwd">
                 
                </div>
             </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <form action="" method="post">
                    <input name="print" type="submit" class="toggle btn btn-primary d-print-none" value="print" onclick="printpage()">
                    
                    <a href="sales_history.php" class="btn btn-primary d-print-none">Go Back</a>

                </form>
                <p></p>
                
                
               
            </div>
        </div>
    </div>

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
         function printpage() {
            window.print() 
        }
    </script>
    
</body>

</html>

<!--Action boxes-->


<!--end-main-container-part-->
<?php

?>