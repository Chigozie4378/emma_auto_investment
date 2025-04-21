<?php
include "../../../autoload/loader.php";

if (isset($_GET['id']) && isset($_SESSION["cart"][$_GET['id']])) {
    $delete = $_GET["id"];
    unset($_SESSION["cart"][$delete]);
    $_SESSION["cart"] = array_values($_SESSION["cart"]); // Reset indexes
}
?>
