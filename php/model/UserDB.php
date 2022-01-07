<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO user (`username`, `name`, `surname`, `address`, `email`, `password`, `role`) "
            . " VALUES (:username, :name, :surname, :address, :email, :password, :role)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE user SET username = :username"
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
        return parent::query("SELECT `id`, `username`, `name`, `surname`, `address`, `email`, `password`, `role`"
            . " FROM user"
            . " ORDER BY id ASC");
    }

    public static function checkUsername($params)
    {
        return parent::query("SELECT `id`, `username`, `password`, `role`"
            . " FROM user"
            . " WHERE `username` = :username", $params);
    }

    public static function register(array $params)
    {
        if (empty(self::checkUsername($params))) {
            $param_password = password_hash($params["password"], PASSWORD_DEFAULT);

            $params["password"] = $param_password;
            self::insert($params);

            $dbUser = self::checkUsername($params);
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $dbUser[0]["id"];
            $_SESSION["role"] = $dbUser[0]["role"];
            $_SESSION["username"] = $dbUser[0]["username"];
            $_SESSION["total"] = 0;
            return 0;
        } else {
            print("Username already exists!");
            return -1;
        }
    }

    public static function login(array $params)
    {
        $dbUser = self::checkUsername($params);
        if (!empty($dbUser)) {
            if (password_verify($params["password"], $dbUser[0]["password"])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $dbUser[0]["id"];
                $_SESSION["role"] = $dbUser[0]["role"];
                $_SESSION["username"] = $dbUser[0]["username"];
                $_SESSION["total"] = 0;
            } else {
                return -2;
            }
        } else {
            return -1;
        }
    }

    public static function updateUsername(array $params)
    {
        $dbUser = self::checkUsername($params);
        if (empty($dbUser)) {
            $_SESSION["username"] = $params["username"];
            self::updateUsernameHelper($params);
        } else {
            print("Username already taken!");
            return -1;
        }
    }
    public static function updateUsernameHelper(array $params)
    {
        return parent::modify("UPDATE user SET username = :username"
            . " WHERE id = :id", $params);
    }

    public static function updatePassword(array $params)
    {
        $param_password = password_hash($params["password"], PASSWORD_DEFAULT);
        $params["password"] = $param_password;

        self::updatePasswordHelper($params);
    }
    public static function updatePasswordHelper(array $params)
    {
        return parent::modify("UPDATE user SET `password` = :password"
            . " WHERE id = :id", $params);
    }
}
