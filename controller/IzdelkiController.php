<?php

require_once("model/IzdelkiDB.php");
require_once("ViewHelper.php");

class IzdelkiController {

    public static function izdelkiview() {        
        echo ViewHelper::render("view/izdelki-list.php", [
                "izdelki" => IzdelkiDB::getAll()
            ]);
    }

}
