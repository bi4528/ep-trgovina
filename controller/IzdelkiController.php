<?php

require_once("model/IzdelkiDB.php");
require_once("ViewHelper.php");
require_once("view/forms/izdelek-form.php");

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
    
    public static function addizdelek() {
        //var_dump($_SESSION);
        if (isset($_SESSION["vloga"]) && $_SESSION["vloga"] == "prodajalec") {
            $form = new IzdelekForm("dodajizdelek");
            if($form->validate()) {
                $izdelek = $form->getValue();

                $params["ime"] = $izdelek["ime"];
                $params["opis"] = $izdelek["opis"];
                $params["cena"] = $izdelek["cena"];
                $params["prodajalec_id"] = $_SESSION["id"];
                $params["aktiven"] = 1;

                //var_dump($params);
                IzdelkiDB::insert($params);

            }else {
                echo ViewHelper::render("view/dodaj-izdelek.php", [
                   "form" => $form 
                ]);
            }
        }else {
            echo "Nepooblaščen dostop";
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
        
    
