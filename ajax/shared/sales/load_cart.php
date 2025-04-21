<?php
include "../../../autoload/loader.php";
$ctr = new SalesController();
$productname= $_POST["productname"];
$model= $_POST["model"];
$manufacturer= $_POST["manufacturer"];
$quantity = $_POST["quantity"];
$price= $_POST["price"];
$total= $_POST["total"];
$qty= $_POST["qty_db"];

if (isset($_SESSION["cart"])){
    $max  = sizeof($_SESSION["cart"]);
    $check_available = 0;
    $check_available = checkDuplicateCart($productname,$model,$manufacturer);
    $available_qty=0;
    $check_the_qty = 0;

    if ($check_available==0){
        $available_qty = checkQty();
        if ($available_qty >= $quantity){
            $b = array("productname"=>$productname,"model"=>$model,"manufacturer"=>$manufacturer,"quantity"=>$quantity,"price"=>$price);
            array_push($_SESSION["cart"],$b);
        }else{
            echo "Entered quantity not available";
        }

    }else{
        $av_qty = 0;
        $exist_qty =0;
        $exist_qty = checkQtyCart($productname,$model,$manufacturer);
        $exist_qty = $exist_qty+$quantity;
        $av_qty = checkQty();
        if ($av_qty>=$exist_qty){
            $product_no_session = addToQtyInCart($productname,$model,$manufacturer);
            $b = array("productname"=>$productname,"model"=>$model,"manufacturer"=>$manufacturer,"quantity"=>$exist_qty,"price"=>$price);
            $_SESSION["cart"][$product_no_session]=$b; 
        }else{
            echo "Entered quantity not available";
        }
    }
}else{
    $available_qty = checkQty();
    if ($available_qty=$quantity){
        $_SESSION["cart"]=array(array("productname"=>$productname,"model"=>$model,"manufacturer"=>$manufacturer,"quantity"=>$quantity,"price"=>$price));
    }else{
        echo "entered quantity not available";
    }
}

function checkQty(){
    $qty= $_POST["qty_db"];
    return $qty;

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