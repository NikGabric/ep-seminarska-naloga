<?php

require_once("model/CubeDB.php");
require_once("controller/CubesController.php");
require_once("ViewHelper.php");

class CubesRESTController
{

    public static function get($id)
    {
        try {
            echo ViewHelper::renderJSON(CubeDB::get(["cube_id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function getAll()
    {
        try {
            echo ViewHelper::renderJSON(CubeDB::getAll());
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function index()
    {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
            . $_SERVER["REQUEST_URI"];
        echo ViewHelper::renderJSON(CubeDB::getAllwithURI(["prefix" => $prefix]));
    }
}
