<?php

require_once("model/UporabnikDB.php");
require_once("ViewHelper.php");

class UporabnikiController {

    public static function prijava() {
        echo ViewHelper::render("view/prijava.php");
    }
    
    public static function registracija() {
        echo ViewHelper::render("view/registracija.php");
    }
    
    public static function adminview() {        
        echo ViewHelper::render("view/admin-home.php", [
                "admin" => UprabnikDB::getAdmin(),
                "prodajalci" => UprabnikDB::getProdajalci()
            ]);
    }
    
    public static function prodajalecview() {        
        echo ViewHelper::render("view/prodajalec-home.php", [
                "stranke" => UprabnikDB::getStranke()
            ]);
    }
    
    public static function index() {
        

        

        
    }

}
