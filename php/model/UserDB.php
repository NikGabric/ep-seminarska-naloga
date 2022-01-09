<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO user (`username`, `name`, `surname`, `address`, `email`, `password`, `role`, `status`) "
            . " VALUES (:username, :name, :surname, :address, :email, :password, :role, :status)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE user SET username = :username"
            . "cube_type = :cube_type, price = :price"
            . " WHERE user_id = :user_id", $params);
    }

    public static function delete(array $user_id)
    {
        return parent::modify("DELETE FROM rubiks_cube WHERE user_id = :user_id", $user_id);
    }

    public static function get(array $user_id)
    {
        $cubes = parent::query("SELECT user_id, cube_name, manufacturer, cube_type, price"
            . " FROM rubiks_cube"
            . " WHERE user_id = :user_id", $user_id);
    }

    public static function getAll()
    {
        return parent::query("SELECT `user_id`, `username`, `name`, `surname`, `address`, `email`, `password`, `role`"
            . " FROM user"
            . " ORDER BY user_id ASC");
    }

    public static function checkUsername($params)
    {
        return parent::query("SELECT `user_id`, `username`, `password`, `role`, `status`"
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
            $_SESSION["user_id"] = $dbUser[0]["user_id"];
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
        $commonname = openssl_x509_parse(filter_input(INPUT_SERVER, "SSL_CLIENT_CERT"))["subject"]["CN"];

        if (empty($dbUser)) {
            return -1;
        } else if ($dbUser[0]["role"] == "admin" && $commonname != "admin") {
            return -4;
        } else if ($dbUser[0]["status"] == "disabled") {
            return -3;
        } else {
            if (password_verify($params["password"], $dbUser[0]["password"])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $dbUser[0]["user_id"];
                $_SESSION["role"] = $dbUser[0]["role"];
                $_SESSION["username"] = $dbUser[0]["username"];
                $_SESSION["total"] = 0;
            } else {
                return -2;
            }
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
            . " WHERE user_id = :user_id", $params);
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
            . " WHERE user_id = :user_id", $params);
    }

    public static function getSellers()
    {
        return parent::query("SELECT `user_id`, `username`, `role`, `status`"
            . " FROM user"
            . " WHERE role = 'seller'");
    }

    public static function updateAccountStatus($params)
    {
        return parent::modify("UPDATE user SET `status` = :status"
            . " WHERE user_id = :user_id", $params);
    }

    public static function createNewUser(array $params)
    {
        if (empty(self::checkUsername($params))) {
            $param_password = password_hash($params["password"], PASSWORD_DEFAULT);

            $params["password"] = $param_password;
            self::insert($params);

            return 0;
        } else {
            print("Username already exists!");
            return -1;
        }
    }
}
