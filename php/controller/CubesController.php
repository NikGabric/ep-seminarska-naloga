<?php

require_once("ViewHelper.php");
require_once("model/CubeDB.php");

class CubesController
{

    public static function index()
    {
        $rules = [
            "cube_id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);

        if (self::checkValues($data)) {
            echo ViewHelper::render("view/cube-detail.php", [
                "cube" => CubeDB::get($data)
            ]);
        } else {
            echo ViewHelper::render("view/cube-list.php", [
                "cubes" => CubeDB::getAll()
            ]);
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
    public static function checkValues($input)
    {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }

    // /**
    //  * Returns an array of filtering rules for manipulation books
    //  * @return type
    //  */
    public static function getRules()
    {
        return [
            'cube_name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'manufacturer' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cube_type' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => FILTER_VALIDATE_FLOAT,
        ];
    }
}
