<?php

// enables sessions for the entire app
session_start();

require_once("controller/JokesController.php");
require_once("controller/UporabnikiController.php");
require_once("controller/IzdelkiController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

/* Uncomment to see the contents of variables
  var_dump(BASE_URL);
  var_dump(IMAGES_URL);
  var_dump(CSS_URL);
  var_dump($path);
  exit(); */

// ROUTER: defines mapping between URLS and controllers
$urls = [
    "jokes" => function () {
        JokesController::index();
    },
    "jokes/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JokesController::add();
        } else {
            JokesController::addForm();
        }
    },
    "jokes/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JokesController::edit();
        } else {
            JokesController::editForm();
        }
    },
    "jokes/delete" => function () {
        JokesController::delete();
    },
    "jokes/delete" => function () {
        JokesController::delete();
    },
    "registracija" => function () {
        UporabnikiController::add();
    },
    "prijava" => function () {
        UporabnikiController::prijava();
    },
    "odjava" => function () {
        UporabnikiController::odjava();
    },
    "admin" => function () {
        UporabnikiController::adminview();
    },
    "admin/edit" => function () {
        UporabnikiController::editAdmin();
    },
    "admin/edit-prodajalec" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::editAdminProdajalec();
        } else {
            UporabnikiController::adminview();
        }
    },
    "edit/password" => function () {
        UporabnikiController::editpassword();
    },
    "prodajalec" => function () {
        UporabnikiController::prodajalecview();
    },
    "prodajalec/add" => function () {
        UporabnikiController::addprodajalec();
    },
    "prodajalec/edit" => function () {
        UporabnikiController::editProdajalec();
    },
    "prodajalec/edit-stranka" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::editProdajalecStranka();
        } else {
            UporabnikiController::prodajalecview();
        }
    },
    "prodajalec/edit-izdelek" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelkiController::editIzdelek();
        } else {
            UporabnikiController::prodajalecview();
        }
    },
    "prodajalec/aktiviraj" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::aktiviraj();
        } else {
            echo "Nepooblaščen dostop";
        }
    },
    "izdelek/aktiviraj" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelkiController::aktiviraj();
        } else {
            echo "Nepooblaščen dostop";
        }
    },
    "stranka/edit" => function () {
        UporabnikiController::editStranka();
    },
    "stranka/aktiviraj" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::aktiviraj();
        } else {
            echo "Nepooblaščen dostop";
        }
    },
    "izdelki/add" => function () {
        IzdelkiController::addizdelek();
    },
    "izdelki" => function () {
        IzdelkiController::izdelkiview();
    },
    "cart" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelkiController::kosarica();
        }else {
            ViewHelper::redirect(BASE_URL);
        }
    },
    "predracun" => function () {
        IzdelkiController::predracun();
    },
    "oddaj" => function () {
        IzdelkiController::oddajNarocilo();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "izdelki");
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
