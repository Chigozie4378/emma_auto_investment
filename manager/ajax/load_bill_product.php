<?php
session_start();
error_reporting(E_ERROR);
?>
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
    <tr>
        <th>S/N</th>
        <th>Quantity</th>
        <th>Product Name</th>
        <th>Model</th>
        <th>Manufacturer</th>
        <th>Price</th>
        <th>Amount</th>
        <th>Delete</th>
    </tr>
<?php
    $id= 1;
    $qty_found = 0;
    $max= 0;
    $quantity_session=0;
    $total =0;
    
    if (isset($_SESSION["cart"])){
        $max = sizeof($_SESSION['cart']);
    }
    
    for ($i=0; $i < $max; $i++) { 
        $productname_session = "";
        $model_session = "";
        $manufacturer_session = "";
        
        if (isset($_SESSION['cart'][$i])){     
            foreach ($_SESSION["cart"][$i] as $key => $val) {
                if ($key=="productname"){
                    $productname_session = $val;
                }
                elseif ($key=="model"){
                    $model_session = $val;
                }
                elseif ($key=="manufacturer"){
                    $manufacturer_session = $val;
                }
                elseif ($key=="quantity"){
                    $quantity_session = $val;
                }
                elseif ($key=="price"){
                    $price_session = $val;
                }
            }
            
            $total= $total + (int)$quantity_session * (int)$price_session;
            if (!empty($productname_session)){
            ?>
             <tr>
                <td><?php echo $id++?></td>
                <td style="width:10%;text-align:center"> <input class="form-control"  style="width:100%;box-sizing:border-box" type="number" id="qty<?php echo $i?>" 
                value="<?php echo $quantity_session?>"><span style="cursor:pointer"  onclick="updateQty(document.getElementById('qty<?php echo $i?>').value,'<?php echo $productname_session?>','<?php echo $model_session?>','<?php echo $manufacturer_session?>','<?php echo $price_session?>','<?php echo $amount?>')" class="badge badge-pill badge-info">Refresh</span></td>
                <td><?php echo $productname_session?></td>
                <td><?php echo $model_session?></td>
                <td><?php echo $manufacturer_session?></td>
                <td><?php echo $price_session?></td>
                <td><?php echo $amount = (int)$quantity_session * (int)$price_session?></td>
                <td><i style="cursor:pointer; color:red;" onclick="deleteItem('<?php echo $i?>')" class="fas fa-trash"></i></td>
            </tr>
           
          <?php  
        }
     } 
}
?>
<tr>
        <td colspan="6" ><p style="float:right;font-weight:bold">Total Amount: # </p></td>
        <td><p style="font-weight:bold"><span  id="total" ><?php echo  number_format($total,2)?></span></p></td>
        <input type="hidden" name="tot" id="tot" value="<?php echo $total?>">
        <td></td>
        </tr>
        <tr >
        <td colspan="5"></td>
        <td >Cash</td>
        <td style="width:15%;text-align:center"><input class="form-control" style="width:100%;box-sizing:border-box" onkeyup = "cashCalc(this.value,document.getElementById('transfer').value)" type="number" name="cash" id="cash" value="0" required></td>
        <td></td>
       </tr>
        <tr>
        <td colspan="5" ></td>
        <td>Transfer</td>
        <td style="width:15%;text-align:center"><input class="form-control"  style="width:100%;box-sizing:border-box"  onkeyup = "transferCalc(this.value,document.getElementById('cash').value)" type="number" name="transfer" id="transfer" value="0"  required></td>
        <td></td>
        </tr>
        <tr id="paid">
        <td colspan="5"></td>
        <td>Paid</td>
        <td style="width:15%;text-align:center"><input class="form-control"  name="deposit" id="deposit" style="width:100%;box-sizing:border-box" type="number"  readonly value="0"></td>
        <td></td>
        <tr>
        <td colspan="4"></td>
        <td><p style="cursor:pointer;box-sizing:border-box; float:right" onclick= "balanceCalc(document.getElementById('tot').value,document.getElementById('deposit').value)"value="Calculate Bal" class="badge badge-pill badge-success">Calculate Balance</p></td>
        <td >Balance</td>
        <td style="float:right;"><input class="form-control"  style="width:100%;box-sizing:border-box;" type="number" name="balance" id="balance" value="0" readonly></td>
        <td></td>
        </tr>
</table>
</div>





                    