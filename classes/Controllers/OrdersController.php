<?php
class OrdersController extends ControllerV2
{
    public function orders()
    {

        return $this->fetchResult(
            "online_orders",
            join: [
                "online_users" => "online_orders.user_id = online_users.user_id"
            ],
            where: ["online_orders.status=pending"],
            order_by: "online_orders.created_at ASC"
        );
    }
    public function order()
    {


        if (!isset($_GET['oid'])) {
            header("Location: orders.php");
        }

        $oid = $_GET['oid'];
        return $this->fetchResult(
            "online_orders",
            join: [
                "online_users" => "online_orders.user_id = online_users.user_id"
            ],
            where: ["online_orders.order_id=$oid"]
        );
    }
    public function orderDetails()
    {

        if (!isset($_GET['oid'])) {
            header("Location: orders.php");
        }

        $oid = $_GET['oid'];

        return $this->fetchResult(
            "online_order_details",
            join: [
                "online_orders" => "online_order_details.order_id = online_orders.order_id",
                "online_products" => "online_order_details.product_id = online_products.product_id",
                "online_users" => "online_orders.user_id = online_users.user_id"
            ],
            where: ["online_orders.order_id=$oid"]
        );
    }
    public function fetchProductDetails($productName, $model, $manufacturer)
    {
        $results = $this->fetchResult(
            "product",
            where: ["name=$productName", "model=$model", "manufacturer=$manufacturer"]
        );
        return $results->fetch_assoc();
    }

    public function cancelOrder()
    {
        if (isset($_GET['oidcancel'])) {
            $orderId = $_GET['oidcancel'];
            $this->updates(
                "online_orders",
                U::col("status = Cancelled"),
                U::where("order_id = $orderId")
            );
            new Redirect('orders.php');
        }
    }

    public function searchByName($name)
    {
        return $this->fetchResult(
            "online_orders",
            join: [
                "online_users" => "online_orders.user_id = online_users.user_id"
            ],
            where: ["name=$name", "online_orders.status=pending"],
            oper: ["LIKE"],
            order_by: "online_orders.created_at ASC"
        );
    }

    public function searchByAddress($name, $address)
    {
        return $this->fetchResult(
            "online_orders",
            join: [
                "online_users" => "online_orders.user_id = online_users.user_id"
            ],
            where: ["name=$name","address=$address", "online_orders.status=pending"],
            oper: ["LIKE","LIKE"],
            order_by: "online_orders.created_at ASC"
        );
    }
}
