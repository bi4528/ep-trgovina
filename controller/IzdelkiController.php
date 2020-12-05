<?php

require_once("model/IzdelkiDB.php");
require_once("ViewHelper.php");

class IzdelkiController {

    public static function izdelkiview() {        
        echo ViewHelper::render("view/izdelki-list.php", [
                "izdelki" => IzdelkiDB::getAll()
            ]);
    }
    
    public static function addForm($values = [
        "id" => "",
        "ime" => "",
        "opis" => "",
        "cena" => "",
        "prodajalec_id" => ""
    ]) {
        echo ViewHelper::render("view/izdelki-add.php", $values);
    }

    /*public static function add() {
        $data = filter_input_array(INPUT_POST, self::getRules());

        if (self::checkValues($data)) {
            $id = IzdelkiDB::insert($data);
            //echo ViewHelper::redirect(BASE_URL . "prodajalec?id=" . $id);
            echo ViewHelper::render("view/izdelki-list.php", [
                "izdelki" => IzdelkiDB::getAll()
            ]);
        } else {
            self::addForm($data);
        }
    }*/

}
