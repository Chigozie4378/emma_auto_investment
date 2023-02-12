<?php 
session_start();

include 'core/init.php';

$mod = new Model;
?>
<?php 
if (isset($_POST['print'])){
    Session::unset('invoice');
    header('location:retail.php');
}
$select = $mod->showInvoiceSales($_SESSION['invoice']);
$result = mysqli_fetch_array($select);
include 'includes/sales/header.php';
?>


<body style='margin:0px 200px 10px 200px'>
<div class="container-fluid" style="padding-right:30px;padding-left:30px;padding-bottom:160px;margin: bottom 120px;">
        <address class="text-center" style="padding-top:30px;">
            <h4 class="text-dark" style="font-size:35px;font-weight:bolder"><span><img src="../assets/images/depositphotos_143229717-stock-illustration-sport-superbike-motorcycle-with-helmet.jpg" alt="" style="height:80px;width:100px">
                </span>EMMA AUTO AND MULTI-SERVICES COMPANY</h4>
            <p class="text-dark" style="font-size:18px;">Distributor for Chanlin, Shiroro, Unigo, Jeely, Jieng, Endurance, Tako, Donaten, Sinosat,
                and Sunrain Motorcycle spare parts of all brands of Motorcycles and Tricycle parts all Genuine parts, such as Honda, Bajaj, TVS, Hero and all brands of Motorcycles Engine and Tricycles. <br>
                <span style="font-weight: bold">Tel: 08062063060, 08119222292, 07063684266</span>
            </p>
            <span class="bg-danger rounded-pill px-2"">Invoice</span>
               
        </address>
        <div class='row'>
            <div class='col-4'>
                <table class='table table-striped table-light table-bordered '>
                    <tr class='odd gradeX'>
                    <th>NAME:    </th>
                    <td><?php echo $result['customer_name'];?></td>
                    <th>ADDRESS:</th>
                    <td><?php  echo $result['address'];?></td>
                    
                    
                </tr>
               
                <tr class='odd gradeA'>
                    <th>INVOICE NO:</th>
                    <td><?php echo $result['invoice_no'];?></td>
                    <th>PAYMENT TYPE:</th>
                    <td><?php echo $result['payment_type'];?></td>
                </tr>
                
                <tr class='even gradeA'>
                    <th>DATE:</th>
                    <td><?php echo $result['date'];?></td>
                    <th>Sold By:</th>
                    <td>Mr/Mrs <?php $staff = explode(" ",$result['staff_name']);echo $staff[1]; ?></td>
                </tr>
                    
                </table>
                
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-12'>
                <table class='table table-striped table-light table-bordered'>
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
                   $id= 1;
                    $select = $mod->showInvoiceSalesDetails($_SESSION['invoice']);
                    while($row = mysqli_fetch_array($select)){
                    ?>
                   <tr>
                       <td><?php echo $id++?></td>
                       <td style="font-weight: bold;"><?php echo $row['quantity']?></td>
                       <td><?php echo $row['product_name']?></td>
                       <td><?php echo $row['model']?></td>
                       <td><?php echo $row['manufacturer']?></td>
                       <td><?php echo $row['price']?></td>
                       <td><?php echo $row['amount']?></td>
                   </tr> 
                   <?php }?>
                   <tr>
                       <td colspan='5'></td>
                       <td style='font-weight: bold;'>Total Amount:</td>
                       <td style='font-weight: bold;'># <?php echo number_format($result['total'],2);?></td>
                   </tr>
                   <tr>
                    <td colspan='3'></td>
                    <td style='font-weight: bold;'>Cash:# <?php echo number_format($result['cash'],2);?></td>
                    <td style='font-weight: bold;'>Transfer:# <?php echo number_format($result['transfer'],2);?></td>
                    <td style='font-weight: bold;'>Total Payment:</td>
                    <td style='font-weight: bold;'># <?php echo number_format($result['deposit'],2);?></td>
                </tr>
                <tr>
                    <td colspan='5'></td>
                    <td style='font-weight: bold;'>Balance:</td>
                    <td style='font-weight: bold;'># <?php echo number_format($result['balance'],2);?></td>
                </tr>
                </table>
                
            </div>
        </div>
        <div class='row'>
            <div class='col-6'>
               
               <div class='form-inline' >
                <label for='email'>Customer Signature:</label>
                <input type='text' class='form-control' id='email'>
              
                
               </div>
            </div>
            <div class='col-6'>
               
                <div class='form-inline' style='float: right;'>
                 <label  for='pwd'>Manager Signature:</label>
                 <input type='text' class='form-control' id='pwd'>
                 
                </div>
             </div>
        </div>
        <div class='text-center' style='padding: bottom 50px;'>
        <b><i>You Must be Born Again!</i></b>
        </div>
        <p></p>
        <div class='row'>
            <div class='col-12 text-center'>
                <form action=' method='post'>
                    <input name='print' type='submit' class='toggle btn btn-primary d-print-none' value='print' onclick='printpage()'>
                </form>
                
               
            </div>
        </div>
    </div>
    <script src='bootsrap/jquery.js'></script>
    <script src='bootsrap/popper.js'></script>
    <script src='bootsrap/bootstrap.min.js'></script>
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