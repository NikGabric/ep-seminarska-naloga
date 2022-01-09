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
            . " WHERE cube_id = :cube_id", $params);
    }

    public static function delete(array $cube_id)
    {
        return parent::modify("DELETE FROM rubiks_cube WHERE cube_id = :cube_id", $cube_id);
    }

    public static function get(array $cube_id)
    {
        $cubes = parent::query("SELECT cube_id, cube_name, manufacturer, cube_type, price"
            . " FROM rubiks_cube"
            . " WHERE cube_id = :cube_id", $cube_id);

        return $cubes;
    }

    public static function getCubeName(array $cube_id)
    {

        return self::get($cube_id)[0]["cube_name"];
    }

    public static function getAll()
    {
        return parent::query("SELECT cube_id, cube_name, manufacturer, cube_type, price"
            . " FROM rubiks_cube"
            . " ORDER BY cube_id ASC");
    }

    public static function getForIds($cube_ids)
    {
        $db = DBInit::getInstance();

        $cube_id_placeholders = implode(",", array_fill(0, count($cube_ids), "?"));

        $statement = $db->prepare("SELECT cube_id, cube_name, manufacturer, cube_type, price FROM rubiks_cube 
            WHERE cube_id IN (" . $cube_id_placeholders . ")");
        $statement->execute($cube_ids);

        return $statement->fetchAll();
    }

    public static function getAllwithURI(array $prefix)
    {
        return parent::query("SELECT cube_id, cube_name, manufacturer, cube_type, price, "
            . "          CONCAT(:prefix, cube_id) as uri "
            . "FROM rubiks_cube "
            . "ORDER BY cube_id ASC", $prefix);
    }
}
