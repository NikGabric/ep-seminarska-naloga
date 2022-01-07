<?php

require_once 'model/AbstractDB.php';
require_once 'model/DB.php';

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

        return $cubes;
    }

    public static function getCubeName(array $id)
    {

        return self::get($id)[0]["cube_name"];
    }

    public static function getAll()
    {
        return parent::query("SELECT id, cube_name, manufacturer, cube_type, price"
            . " FROM rubiks_cube"
            . " ORDER BY id ASC");
    }

    public static function getForIds($ids)
    {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

        $statement = $db->prepare("SELECT id, cube_name, manufacturer, cube_type, price FROM rubiks_cube 
            WHERE id IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        return $statement->fetchAll();
    }
}
