<?php
include "../../../autoload/loader.php";


$shared = new Shared();
$productname= $_POST["productname"];
$model= $_POST["model"];
$manufacturer= $_POST["manufacturer"];
$quantity = $_POST["quantity"];
$price= $_POST["price"];
$amount= $_POST["amount"];

$av_qty = 0;
$exist_qty =0;
$exist_qty = 0;
$exist_qty = $quantity;
$av_qty = checkQty($productname,$model,$manufacturer);
if ($av_qty>=$exist_qty){
    $product_no_session = addToQtyInCart($productname,$model,$manufacturer);
    $b = array("productname"=>$productname,"model"=>$model,"manufacturer"=>$manufacturer,"quantity"=>$exist_qty,"price"=>$price);
    $_SESSION["cart"][$product_no_session]=$b; 
    echo "Quantity Updated Succesfully";
}else{
    echo "Entered quantity not available";
}

function checkQty($productname,$model,$manufacturer){
    $ctr = new StocksController();
    $select  = $ctr->checkProduct($productname,$model,$manufacturer);
    $row = mysqli_fetch_array($select);
    return $row["quantity"];
}
function checkDuplicateCart($productname,$model,$manufacturer){
     $found = 0;
    $max = sizeof($_SESSION['cart']);
    for ($i=0; $i < $max; $i++) { 
        if (isset($_SESSION['cart'][$i])){
            $productname_session = "";
            $model_session = "";
            $manufacturer_session = "";

            foreach ($_SESSION["cart"][$i] as $key => $val) {
                if ($key=="productname"){
                    $productname_session = $val;
                }
                else if ($key=="model"){
                    $model_session = $val;
                }
                else if ($key=="manufacturer"){
                    $manufacturer_session = $val;
                }
            }
            if ($productname_session == $productname && $model_session == $model && $manufacturer_session==$manufacturer){
                $found = $found+1;
            }
        }
    }
    return $found; 
}
function checkQtyCart($productname,$model,$manufacturer){
    $qty_found = 0;
    $quantity_session=0;
    $max = sizeof($_SESSION['cart']);
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
            }
            if ($productname_session == $productname && $model_session == $model && $manufacturer_session==$manufacturer){
                $qty_found = $quantity_session;
            }
        }
    }
    return $qty_found; 
}
function addToQtyInCart($productname,$model,$manufacturer){
    $record_no = 0;
   $max = sizeof($_SESSION['cart']);
   for ($i=0; $i < $max; $i++) { 
       if (isset($_SESSION['cart'][$i])){
           $productname_session = "";
           $model_session = "";
           $manufacturer_session = "";

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
           }
           if ($productname_session == $productname && $model_session == $model && $manufacturer_session==$manufacturer){
               $record_no = $i;
           }
       }
   }
   return $record_no; 
}
?>