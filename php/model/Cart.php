<?php

require_once("model/CubeDB.php");

class Cart
{

    public static function getAll()
    {

        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            return [];
        }

        $ids = array_keys($_SESSION["cart"]);
        $cart = CubeDB::getForIds($ids);

        foreach ($cart as &$cube) {
            $cube["quantity"] = $_SESSION["cart"][$cube["cube_id"]];
        }

        return $cart;
    }

    public static function add($id)
    {
        $cube = CubeDB::get(["cube_id" => $id]);

        if ($cube != null) {
            if (isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id] += 1;
            } else {
                $_SESSION["cart"][$id] = 1;
            }
        }
    }

    public static function update($id, $quantity)
    {
        $cube = CubeDB::get(["cube_id" => $id]);
        $quantity = intval($quantity);

        if ($cube != null) {
            if ($quantity <= 0) {
                unset($_SESSION["cart"][$id]);
            } else {
                $_SESSION["cart"][$id] = $quantity;
            }
        }
    }

    public static function purge()
    {
        unset($_SESSION["cart"]);
    }

    public static function total()
    {
        return array_reduce(self::getAll(), function ($total, $cube) {
            return $total + $cube["price"] * $cube["quantity"];
        }, 0);
    }
}
