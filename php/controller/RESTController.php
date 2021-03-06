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
    
    public static function add() {
        $data = filter_input_array(INPUT_POST, IzdelkiController::getRules());

        if (IzdelkiController::checkValues($data)) {
            $id = IzdelkiDB::insert($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/izdelki/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function edit($id) {
        // spremenljivka $_PUT ne obstaja, zato jo moremo narediti sami
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = filter_var_array($_PUT, IzdelkiController::getRules());

        if (IzdelkiController::checkValues($data)) {
            $data["id"] = $id;
            IzdelkiDB::update($data);
            echo ViewHelper::renderJSON("", 200);
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function delete($id) {
        try {
            echo ViewHelper::renderJSON(IzdelkiDB::delete(["id" => $id]));
            echo ViewHelper::renderJSON("", 204);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
}