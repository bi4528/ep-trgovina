<?php

require_once("model/JokeDB.php");
require_once("ViewHelper.php");

class UporabnikiController {

    public static function prijava() {
        echo ViewHelper::render("view/prijava.php");
    }
    
    public static function registracija() {
        echo ViewHelper::render("view/registracija.php");
    }

}
