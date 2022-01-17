<?php

require_once("model/CubeDB.php");
require_once("controller/CubesController.php");
require_once("ViewHelper.php");

class CubesRESTController
{

    public static function get($id)
    {
        try {
            echo ViewHelper::renderJSON(CubeDB::get(["cube_id" => $id])[0]);
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

    public static function add()
    {
        $data = filter_input_array(INPUT_POST, CubesController::getRules());

        if (CubesController::checkValues($data)) {
            $id = CubeDB::insert($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/books/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function edit($id)
    {
        $data = filter_input_array(INPUT_POST, CubesController::getRules());

        if (CubesController::checkValues($data)) {
            $data["cube_id"] = $id;
            CubeDB::update($data);
            echo ViewHelper::renderJSON("", 200);
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function delete($id)
    {
        CubeDB::delete(["cube_id" => $id]);
        echo ViewHelper::renderJSON("", 200);
    }
}
