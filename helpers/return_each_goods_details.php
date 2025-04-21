<?php
include '_partial.php';
$return_goods_histories_ctr = new ReturnGoodsHistoriesController();
?>
<?php //$return_goods_histories_ctr->addEachReturn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="icon" href="../assets/images/logo.jpg" type="image/gif" sizes="20x20">

<link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
</head>

<body>
    <div class="container-fluid">
    <address class="text-center" style="padding-top:30px;">
            <h3 class="text-dark" style="font-size:50px;font-weight:bolder"><span><img  src="../assets/images/depositphotos_143229717-stock-illustration-sport-superbike-motorcycle-with-helmet.jpg" alt="" style="height:80px;width:100px">
    </span>EMMA AUTO AND MULTI-SERVICES COMPANY</h3>
               <p class="text-dark" style="font-size:15px;">Supplier of Chanlin, Shiroro, Jeely, Unigo Motorcycle Spare Parts <br>
               <span class="text-danger">Such as: </span>Bajaj, Suzuki, Honda, TVS Etc. <br>
               <span class="text-danger">Address: </span>37, Oppsite Jesus Life Church, Asubiaro Hospital Junction, Osogbo, Osun state, Nig. <br>
            <span style="font-weight: bold">Tel: 08062063060, 08150745390, 07063684266</span> </p> 
               <span class="bg-danger rounded-pill px-2">Return Goods</span>
               
        </address>
        <div class="row">
            <div class="col-4">
                <table class="table table-striped table-light table-bordered">
                    <tr class="odd gradeX">
                    <th>NAME:    </th>
                    <td><?php echo $return_goods_histories_ctr->viewEachReturnGoods("customer_name");?></td>
                    <th>ADDRESS:</th>
                    <td><?php echo  $return_goods_histories_ctr->viewEachReturnGoods("address");?></td>
                    
                    
                </tr>
               
                <tr class="odd gradeA">
                    <th>INVOICE NO:</th>
                    <td><?php echo $return_goods_histories_ctr->viewEachReturnGoods("invoice_no");?></td>
                    <th>PAYMENT TYPE:</th>
                    <td><?php echo $return_goods_histories_ctr->viewEachReturnGoods("payment_type");?></td>
                </tr>
                
                <tr class="even gradeA">
                    <th>DATE:</th>
                    <td><?php echo $return_goods_histories_ctr->viewEachReturnGoods("date");?></td>
                    <td colspan="2"></td>
                </tr>
                    
                </table>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 fixTableHead">
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
                  $id = 0;
                  $result = $return_goods_histories_ctr->viewReturnGoodsDetails();
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
                 
                <h3 class="text-white"</h3>
                       <td style="font-weight: bold;"># <?php echo number_format($return_goods_histories_ctr->viewEachReturnGoods("total"));?></td>
                   </tr>
                </table>
                
            </div>
        </div>
        <div class="row">
            <div class="col-6">
               
               <div class="form-inline" >
                <label for="email">Customer Signature:</label>
                <input type="text" class="form-control" >
              
                
               </div>
            </div>
            <div class="col-6">
               
                <div class="form-inline" style="float: right;">
                 <label  for="pwd">Manager Signature:</label>
                 <input type="text" class="form-control" value= "<?php $return_goods_histories_ctr->viewEachReturnGoods("staff_name");?>">
                 
                </div>
             </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
            <form action="" method="post">
                    <a href="javascript:history.back()" class="btn btn-default">Go Back</a> 
                    <input name="print" type="submit" class="toggle btn btn-primary d-print-none" value="print" onclick="printpage()">
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