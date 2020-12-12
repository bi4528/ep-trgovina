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

//var_dump($_SESSION);



// ROUTER: defines mapping between URLS and controllers
$urls = [
    "registracija" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::add();
    },
    "prijava" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::prijava();
    },
    "prijava/osebje" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::prijavaosebje();
    },
    "odjava" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::odjava();
    },
    "admin" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::adminview();
    },
    "admin/edit" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::editAdmin();
    },
    "admin/edit-prodajalec" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::editAdminProdajalec();
        } else {
            UporabnikiController::adminview();
        }
    },
    "edit/password" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::editpassword();
    },
    "prodajalec" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::prodajalecview();
    },
    "prodajalec/add" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::addprodajalec();
    },
    "prodajalec/edit" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::editProdajalec();
    },
    "prodajalec/edit-stranka" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::editProdajalecStranka();
        } else {
            UporabnikiController::prodajalecview();
        }
    },
    "prodajalec/edit-izdelek" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelkiController::editIzdelek();
        } else {
            UporabnikiController::prodajalecview();
        }
    },
    "prodajalec/aktiviraj" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::aktiviraj();
        } else {
            echo "Nepooblaščen dostop";
        }
    },
    "izdelek/aktiviraj" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelkiController::aktiviraj();
        } else {
            echo "Nepooblaščen dostop";
        }
    },
    "stranka/edit" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        UporabnikiController::editStranka();
    },
    "stranka/aktiviraj" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UporabnikiController::aktiviraj();
        } else {
            echo "Nepooblaščen dostop";
        }
    },
    "izdelki/add" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        IzdelkiController::addizdelek();
    },
    "izdelki" => function () {
        if (!isset($_SERVER["HTTPS"]) && isset($_SESSION["id"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }        
        IzdelkiController::izdelkiview();
    },
    "cart" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelkiController::kosarica();
        }else {
            ViewHelper::redirect(BASE_URL);
        }
    },
    "predracun" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
        IzdelkiController::predracun();
    },
    "oddaj" => function () {
        if (!isset($_SERVER["HTTPS"])) {
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }
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
