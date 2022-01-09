<?php

require_once 'model/AbstractDB.php';
require_once 'model/DB.php';

class OrderDB extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO finished_order (customer_id, order_status, order_total) "
            . " VALUES (:customer_id, :order_status, :order_total)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE finished_order SET order_status = :order_status"
            . " WHERE order_id = :order_id", $params);
    }

    public static function delete(array $id)
    {
        return parent::modify("DELETE FROM rubiks_cube WHERE id = :id", $id);
    }

    public static function get(array $id)
    {
        $cubes = parent::query("SELECT id, cube_name, manufacturer, cube_type, price"
            . " FROM rubiks_cube"
            . " WHERE id = :id", $id);

        return $cubes;
    }

    public static function getCubeName(array $id)
    {

        return self::get($id)[0]["cube_name"];
    }

    public static function getAll()
    {
        $orderIds = parent::query("SELECT order_id, order_status, order_total"
            . " FROM finished_order");

        $orders = [];

        foreach ($orderIds as $order) {
            $orderDetails = self::getOrderDetails(["order_id" => $order["order_id"]]);
            $orderDetails["order_total"] = $order["order_total"];
            $orderDetails["order_status"] = $order["order_status"];
            $orders[$order["order_id"]] = $orderDetails;
        }

        return $orders;
    }

    // `order_id` int(8) NOT NULL AUTO_INCREMENT,
    // `customer_id` int(8) NOT NULL,
    // `order_status` varchar(15) NOT NULL,
    // `order_total` float NOT NULL,
    public static function insertFinishedOrder(array $params)
    {
        var_dump($params);
        return parent::modify("INSERT INTO finished_order (customer_id, order_status, order_total) "
            . " VALUES (:customer_id, :order_status, :order_total)", $params);
    }

    // `detail_id` int(8) NOT NULL AUTO_INCREMENT,
    // `order_id` int(8) NOT NULL,
    // `product_id` int(8) NOT NULL,
    // `product_price` float NOT NULL,
    // `product_quantity` int(8) NOT NULL,
    public static function insertOrderDetails(array $params)
    {
        return parent::modify("INSERT INTO order_detail (order_id, product_id, product_price, product_quantity) "
            . " VALUES (:order_id, :product_id, :product_price, :product_quantity)", $params);
    }

    public static function getForCustomerId(array $id)
    {
        $orderIds = parent::query("SELECT order_id, order_status, order_total"
            . " FROM finished_order"
            . " WHERE customer_id = :customer_id", $id);

        $orders = [];

        foreach ($orderIds as $order) {
            $orderDetails = self::getOrderDetails(["order_id" => $order["order_id"]]);
            $orderDetails["order_total"] = $order["order_total"];
            $orderDetails["order_status"] = $order["order_status"];
            $orders[$order["order_id"]] = $orderDetails;
        }

        return $orders;
    }

    public static function getOrderDetails(array $id)
    {
        $cubes = [$id["order_id"] => parent::query("SELECT product_id, product_quantity"
            . " FROM order_detail"
            . " WHERE order_id = :order_id", $id)];

        return $cubes;
    }
}
