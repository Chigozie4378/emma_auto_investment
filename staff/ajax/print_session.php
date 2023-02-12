<?php
session_start();
$max=0;
if(isset($_SESSION['cart']))
{
    $max = sizeof($_SESSION['cart']);
}
for ($i = 0;$i < $max; $i++)
{
    if (isset($_SESSION['cart'][$i])) {
        $productname = "";
        $model = "";
        $manufacturer = "";
        $quantity = "";
        
        foreach ($_SESSION["cart"][$i] as $key => $val) {
            if ($key=="productname"){
                $productname = $val;
            }
            elseif ($key=="model"){
                $model= $val;
            }
            elseif ($key=="manufacturer"){
                $manufacturer= $val;
            }
            elseif ($key=="quantity"){
                $quantity = $val;
            }
        }
       
        echo $productname." ".$model." ".$manufacturer." ".$quantity;
        echo "<br>";
    }


}
?>
