<?php

require_once 'model/AbstractDB.php';

class CubeDB extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO rubiks_cube (cube_name, manufacturer, cube_type, price) "
            . " VALUES (:cube_name, :manufacturer, :cube_type, :price)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE rubiks_cube SET cube_name = :cube_name, manufacturer = :manufacturer, "
            . "cube_type = :cube_type, price = :price"
            . " WHERE id = :id", $params);
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
    }

    public static function getAll()
    {
        return parent::query("SELECT id, cube_name, manufacturer, cube_type, price"
            . " FROM rubiks_cube"
            . " ORDER BY id ASC");
    }
}
