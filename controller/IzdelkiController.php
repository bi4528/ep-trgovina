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
        "prodajalec_id" => "",
        "aktiven" => ""
    ]) {
        echo ViewHelper::render("view/izdelki-add.php", $values);
    }

    public static function add() {
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
    }
    
    
        private static function getRules() {
        return [
            'ime' => FILTER_SANITIZE_SPECIAL_CHARS,
            'opis' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cena' => FILTER_VALIDATE_FLOAT,
            'prodajalec_id' => FILTER_SANITIZE_SPECIAL_CHARS,
            'aktiven' =>FILTER_VALIDATE_INT
            
        ];}
        
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

    }
        
    
