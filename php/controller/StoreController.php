<?php

require_once("model/CubeDB.php");
require_once("model/Cart.php");
require_once("model/OrderDB.php");
require_once("ViewHelper.php");

class StoreController
{

    public static function index()
    {
        $vars = [
            "books" => CubeDB::getAll(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];

        ViewHelper::render("view/store-index.php", $vars);
    }

    public static function addToCart()
    {
        $id = isset($_POST["cube_id"]) ? intval($_POST["cube_id"]) : null;

        if ($id !== null) {
            Cart::add($id);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function updateCart()
    {
        $id = (isset($_POST["cube_id"])) ? intval($_POST["cube_id"]) : null;
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;

        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function purgeCart()
    {
        Cart::purge();

        ViewHelper::redirect(BASE_URL . "store");
    }

    // `order_id` int(8) NOT NULL AUTO_INCREMENT,
    // `customer_id` int(8) NOT NULL,
    // `order_status` varchar(15) NOT NULL,
    // `order_total` float NOT NULL,

    // `detail_id` int(8) NOT NULL AUTO_INCREMENT,
    // `order_id` int(8) NOT NULL,
    // `product_id` int(8) NOT NULL,
    // `product_price` float NOT NULL,
    // `product_quantity` int(8) NOT NULL,

    public static function finishOrder()
    {
        $paramsFinished = [];
        $paramsFinished["customer_id"] = $_SESSION["user_id"];
        $paramsFinished["order_status"] = "pending";
        $paramsFinished["order_total"] = Cart::total();

        $orderId = OrderDB::insertFinishedOrder($paramsFinished);

        foreach ($_SESSION["cart"] as $id => $quantity) {
            $paramsDetail = [];
            $paramsDetail["order_id"] = $orderId;
            $paramsDetail["product_id"] = $id;
            $paramsDetail["product_price"] = CubeDB::get(["cube_id" => $id])[0]["price"];
            $paramsDetail["product_quantity"] = $quantity;
            var_dump($paramsDetail);

            OrderDB::insertOrderDetails($paramsDetail);
        }

        Cart::purge();

        ViewHelper::redirect(BASE_URL . "store");
    }
    public static function finishOrderForm()
    {
        echo ViewHelper::render("view/order-form.php", []);
    }

    public static function updateOrderStatus()
    {
        OrderDB::update([
            "order_id" => $_POST["order_id"],
            "order_status" => $_POST["order_status"]
        ]);

        echo ViewHelper::render("view/finished-orders.php", [
            "orders" => OrderDB::getAll()
        ]);
    }
    public static function finishedOrdersForm()
    {
        echo ViewHelper::render("view/finished-orders.php", [
            "orders" => OrderDB::getAll()
        ]);
    }
}
