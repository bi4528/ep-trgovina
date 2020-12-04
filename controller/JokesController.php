<?php

require_once("model/JokeDB.php");
require_once("ViewHelper.php");

class JokesController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);

        if (self::checkValues($data)) {
            echo ViewHelper::render("view/joke-list.php", [
                "jokes" => BookDB::getAll()
            ]);
        } else {
            echo ViewHelper::render("view/joke-list.php", [
                "jokes" => BookDB::getAll()
            ]);
        }
    }

    public static function addForm($values = [
        "id" => "",
        "joke_text" => "",
        "joke_date" => ""
    ]) {
        echo ViewHelper::render("view/joke-add.php", $values);
    }

    public static function add() {
        $data = filter_input_array(INPUT_POST, self::getRules());

        if (self::checkValues($data)) {
            $id = BookDB::insert($data);
            echo ViewHelper::redirect(BASE_URL . "jokes?id=" . $id);
        } else {
            self::addForm($data);
        }
    }

    public static function editForm($joke = []) {
        if (empty($joke)) {
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $data = filter_input_array(INPUT_GET, $rules);

            if (!self::checkValues($data)) {
                throw new InvalidArgumentException();
            }

            $joke = BookDB::get($data);
        }

        echo ViewHelper::render("view/joke-edit.php", ["joke" => $joke]);
    }

    public static function edit() {
        $rules = self::getRules();
        $rules["id"] = [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if (self::checkValues($data)) {
            BookDB::update($data);
            ViewHelper::redirect(BASE_URL . "jokes");
        } else {
            self::editForm($data);
        }
    }

    public static function delete() {
        $rules = [
            'delete_confirmation' => FILTER_REQUIRE_SCALAR,
            'id' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if (self::checkValues($data)) {
            BookDB::delete($data);
            $url = BASE_URL . "jokes";
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "jokes/edit?id=" . $data["id"];
            } else {
                $url = BASE_URL . "jokes";
            }
        }

        ViewHelper::redirect($url);
    }

    /**
     * Returns TRUE if given $input array contains no FALSE values
     * @param type $input
     * @return type
     */
    private static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }

    /**
     * Returns an array of filtering rules for manipulation jokes
     * @return type
     */
    private static function getRules() {
        return [
            'joke_text' => FILTER_SANITIZE_SPECIAL_CHARS,
            'joke_date' => FILTER_SANITIZE_SPECIAL_CHARS
        ];
    }

}
