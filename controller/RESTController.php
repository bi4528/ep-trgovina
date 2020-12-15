<?php

require_once("model/IzdelkiDB.php");
require_once("model/NarocilaDB.php");
require_once("model/izdelekNarocilaDB.php");
require_once("controller/IzdelkiController.php");
require_once("controller/UporabnikiController.php");
require_once("ViewHelper.php");

class RESTController {

    public static function get($id) {
        try {
            $izdelek = IzdelkiDB::getAttributes(["id" => $id]);
            //var_dump($izdelek);
            echo ViewHelper::renderJSON($izdelek);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
    
    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"];
        echo ViewHelper::renderJSON(IzdelkiDB::getAll());
    }
}