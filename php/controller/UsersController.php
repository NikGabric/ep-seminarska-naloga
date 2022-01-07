<?php

require_once("ViewHelper.php");
require_once("model/CubeDB.php");
require_once("model/UserDB.php");

class UsersController
{
    public static function registerForm($values = [
        "role" => "",
        "name" => "",
        "surname" => "",
        "address" => "",
        "email" => "",
        "username" => "",
        "password" => "",
    ])
    {
        echo ViewHelper::render("view/register.php", $values);
    }

    public static function register()
    {
        $rules = [
            'role' => FILTER_SANITIZE_SPECIAL_CHARS,
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'surname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'address' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_SPECIAL_CHARS,
            'username' => FILTER_SANITIZE_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if (self::checkValues($data)) {
            $id = UserDB::register($data);
            if ($id == -1) {
                print("Username taken!");
                self::registerForm($data);
            } else {
                echo ViewHelper::render("view/cube-list.php", [
                    "cubes" => CubeDB::getAll()
                ]);
            }
        } else {
            print("Fill all fields!");
            self::registerForm();
            // echo ViewHelper::render("view/cube-list.php", [
            //     "cubes" => CubeDB::getAll()
            // ]);
        }
    }

    public static function loginForm($values = [
        "username" => "",
        "password" => "",
    ])
    {
        echo ViewHelper::render("view/login.php", $values);
    }

    public static function login()
    {

        $rules = [
            'username' => FILTER_SANITIZE_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        $data = filter_input_array(INPUT_POST, $rules);
        $data['role'] = "temp_role";

        if (self::checkValues($data)) {
            $id = UserDB::login($data);
            if ($id == -2) {
                print("Wrong password!");
                self::loginForm();
            } else if ($id == -1) {
                print("Wrong username!");
                self::loginForm();
            } else {
                echo ViewHelper::render("view/cube-list.php", [
                    "cubes" => CubeDB::getAll()
                ]);
            }
        } else {
            echo ViewHelper::render("view/cube-list.php", [
                "cubes" => CubeDB::getAll()
            ]);
        }
    }

    public static function accountDashboard()
    {
        echo ViewHelper::render("view/account-dashboard.php");
    }

    public static function editUsername($id)
    {
        $rules = [
            'username' => FILTER_SANITIZE_SPECIAL_CHARS
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if ($data["username"] == $_SESSION["username"]) {
            echo ViewHelper::render("view/account-dashboard.php", []);
            return 0;
        }

        if (isset($data["username"]) && $data["username"] != "") {
            $data["id"] = $_SESSION["id"];
            $status = UserDB::updateUsername($data);

            if ($status == -1) {
                print("Username already taken!");
                echo ViewHelper::render("view/account-dashboard.php", []);
            } else {
                print("Updated username!");
                echo ViewHelper::render("view/account-dashboard.php", []);
            }
        } else {
            print("Username can't be empty!");
            echo ViewHelper::render("view/account-dashboard.php", []);
        }
    }

    public static function editPassword($id)
    {
        $rules = [
            'password' => FILTER_SANITIZE_SPECIAL_CHARS
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if (isset($data["password"]) && $data["password"] != "") {
            $data["id"] = $_SESSION["id"];
            $status = UserDB::updatePassword($data);

            if ($status == -1) {
                echo ViewHelper::render("view/account-dashboard.php", []);
            } else {
                print("Updated password!");
                echo ViewHelper::render("view/account-dashboard.php", []);
            }
        } else {
            print("Password can't be empty!");
            echo ViewHelper::render("view/account-dashboard.php", []);
        }
    }

    // public static function addForm($values = [
    //     "author" => "",
    //     "title" => "",
    //     "price" => "",
    //     "year" => "",
    //     "description" => ""
    // ]) {
    //     echo ViewHelper::render("view/book-add.php", $values);
    // }

    // public static function add() {
    //     $data = filter_input_array(INPUT_POST, self::getRules());

    //     if (self::checkValues($data)) {
    //         $id = BookDB::insert($data);
    //         echo ViewHelper::redirect(BASE_URL . "books?id=" . $id);
    //     } else {
    //         self::addForm($data);
    //     }
    // }

    // public static function editForm($book = []) {
    //     if (empty($book)) {
    //         $rules = [
    //             "id" => [
    //                 'filter' => FILTER_VALIDATE_INT,
    //                 'options' => ['min_range' => 1]
    //             ]
    //         ];

    //         $data = filter_input_array(INPUT_GET, $rules);

    //         if (!self::checkValues($data)) {
    //             throw new InvalidArgumentException();
    //         }

    //         $book = BookDB::get($data);
    //     }

    //     echo ViewHelper::render("view/book-edit.php", ["book" => $book]);
    // }

    // public static function edit() {
    //     $rules = self::getRules();
    //     $rules["id"] = [
    //         'filter' => FILTER_VALIDATE_INT,
    //         'options' => ['min_range' => 1]
    //     ];
    //     $data = filter_input_array(INPUT_POST, $rules);

    //     if (self::checkValues($data)) {
    //         BookDB::update($data);
    //         ViewHelper::redirect(BASE_URL . "books?id=" . $data["id"]);
    //     } else {
    //         self::editForm($data);
    //     }
    // }

    // public static function delete() {
    //     $rules = [
    //         'delete_confirmation' => FILTER_REQUIRE_SCALAR,
    //         'id' => [
    //             'filter' => FILTER_VALIDATE_INT,
    //             'options' => ['min_range' => 1]
    //         ]
    //     ];
    //     $data = filter_input_array(INPUT_POST, $rules);

    //     if (self::checkValues($data)) {
    //         BookDB::delete($data);
    //         $url = BASE_URL . "books";
    //     } else {
    //         if (isset($data["id"])) {
    //             $url = BASE_URL . "books/edit?id=" . $data["id"];
    //         } else {
    //             $url = BASE_URL . "books";
    //         }
    //     }

    //     ViewHelper::redirect($url);
    // }

    // /**
    //  * Returns TRUE if given $input array contains no FALSE values
    //  * @param type $input
    //  * @return type
    //  */
    private static function checkValues($input)
    {
        if (empty($input)) {
            return FALSE;
        }

        if ($input["role"] != "customer") {
            $input["address"] = "temp_address";
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        if ($input["role"] != "customer") {
            $input["address"] = null;
        }

        return $result;
    }
}
