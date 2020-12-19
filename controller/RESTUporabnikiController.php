<?php

require_once("model/IzdelkiDB.php");
require_once("model/NarocilaDB.php");
require_once("model/UporabnikDB.php");
require_once("model/izdelekNarocilaDB.php");
require_once("controller/IzdelkiController.php");
require_once("controller/UporabnikiController.php");
require_once("ViewHelper.php");

class RESTUporabnikiController {
    const SALT = '$1$trgovina$';
    
    public static function get($id) {
        try {
            $izdelek = UprabnikDB::getAttributes(["id" => $id]);
            //var_dump($izdelek);
            echo ViewHelper::renderJSON($izdelek);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
    
    public static function getByEmail($email){
        try {
            $izdelek = UprabnikDB::getAttributesEmail(["email" => $email]);
            //var_dump($izdelek);
            echo ViewHelper::renderJSON($izdelek);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
    
    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"];
        echo ViewHelper::renderJSON(UprabnikDB::getAll());
    }
    
    public static function add() {
        $data = filter_input_array(INPUT_POST, UporabnikiController::getRules());

        if (UporabnikiController::checkValues($data)) {
            $id = UprabnikDB::insert($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/uporabniki/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function edit($id) {
        // spremenljivka $_PUT ne obstaja, zato jo moremo narediti sami
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = filter_var_array($_PUT, UporabnikiController::getRules());

        if (UporabnikiController::checkValues($data)) {
            $data["id"] = $id;
            UprabnikDB::update($data);
            echo ViewHelper::renderJSON("", 200);
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }
    
    public static function verify() {
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = filter_var_array($_PUT, UporabnikiController::getRules());
        $geslo = $data["geslo"];
        $up = UprabnikDB::getup(array("email" => $data["email"]));
        
        if ($up != null) {
            $up = $up[0];
            if (crypt($geslo, self::SALT) == $up["geslo"]) {
                if ($up["aktiven"] == 1) {
                    ViewHelper::renderJSON("OK.", 200);
                }else {
                    echo ViewHelper::renderJSON("Forbidden.", 403);
                }
            }else {
                echo ViewHelper::renderJSON("Unauthorized.", 401);
            }
        }else {
            echo ViewHelper::renderJSON("Unauthorized.", 401);
        }
        
    }

    public static function delete($id) {
        try {
            echo ViewHelper::renderJSON(UprabnikDB::delete(["id" => $id]));
            echo ViewHelper::renderJSON("", 204);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
}