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
                echo "Izdelek je bil uspešno dodan!";
                echo '<p>' . '<a href="' . BASE_URL . 'prodajalec' . '">Nazaj prodajalec portal.</a>' . '</p>';
            }else {
                echo ViewHelper::render("view/dodaj-izdelek.php", [
                   "form" => $form 
                ]);
            }
        }else {
            echo "Nepooblaščen dostop";
        }
        
    }
    
    public static function editIzdelek() {
        // VARNOST: Prodajalec lahko ureja le svoje izdelke
        if (isset($_SESSION["vloga"]) && $_SESSION["vloga"] == "prodajalec") {
            $form = new IzdelekForm("dodajizdelek");
            if($form->validate()) {
                $izdelek = $form->getValue();

                $params["ime"] = $izdelek["ime"];
                $params["opis"] = $izdelek["opis"];
                $params["cena"] = $izdelek["cena"];
                $params["id"] = $_SESSION["id2edit"];

                //var_dump($params);
                IzdelkiDB::updateAttributes($params);
                echo "Izdelek je bil uspešno spremenjen!";
                echo '<p>' . '<a href="' . BASE_URL . 'prodajalec' . '">Nazaj prodajalec portal.</a>' . '</p>';
            }else {
                if (isset($_SESSION["id2edit"])) {
                    $atributi = IzdelkiDB::getAttributes(array("id" => $_SESSION["id2edit"]));
                    $atributi = $atributi[0];
                }else {
                    $atributi = IzdelkiDB::getAttributes(array("id" => $_POST["id"]));
                    $atributi = $atributi[0];
                    $_SESSION["id2edit"] = $_POST["id"];
                }

                if ($_SESSION["id"] == $atributi["prodajalec_id"]){
                    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                        "ime" => $atributi["ime"],
                        "opis" => $atributi["opis"],
                        "cena" => $atributi["cena"]
                    )));

                    echo ViewHelper::render("view/uredi.php", [
                       "form" => $form
                    ]);
                }else {
                    echo "Nepooblaščeni dostop.";
                }
            }
        }
        
    }
    
    public static function aktiviraj() {
        // VARNOST: Izdelek lahko aktivira/deaktivira 
        //          le njegov prodajalec
        $atributi = IzdelkiDB::getAttributes(array("id" => $_POST["id"]));
        $atributi = $atributi[0];
        var_dump($atributi);
        if ($_SESSION["id"] == $atributi["prodajalec_id"]) {
            if ($atributi["aktiven"] == 1) {
                $parametri["aktiven"] = 0;
            }else {
                $parametri["aktiven"] = 1;
            }
            $parametri["id"] = $_POST["id"];
            IzdelkiDB::changeAktiven($parametri);
            ViewHelper::redirect(BASE_URL . 'prodajalec');
        }else {
            echo "Nepooblaščen dostop";
        }   
    }
    
    public static function kosarica() {
        $method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
        if($method == "POST") {
            $validationRules = [
                'do' => [
                    'filter' => FILTER_VALIDATE_REGEXP,
                    'options' => [
                        "regexp" => "/^(add_into_cart|purge_cart|updt)$/"
                    ]
                ],
                'id' => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 0]
                ],
                'kolicina' => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 0]
                ]
            ];
        }
        $post = filter_input_array(INPUT_POST, $validationRules);
        var_dump($post);
        
        switch ($post["do"]) {
            case "add_into_cart":
                try {
                    if(isset($_SESSION["cart"][$post["id"]])) {
                        $_SESSION["cart"][$post["id"]]++;
                    }else {
                        $_SESSION["cart"][$post["id"]] = 1;
                    }
                    ViewHelper::redirect(BASE_URL);
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                break;
            case "purge_cart":
                try {
                    unset($_SESSION["cart"]);
                    ViewHelper::redirect(BASE_URL);
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
            case "updt":
                try {
                    if(isset($_SESSION["cart"][$post["id"]])) {
                        if ($post["kolicina"] < 1) {
                            unset($_SESSION["cart"][$post["id"]]);
                        }else {
                            $_SESSION["cart"][$post["id"]] = $post["kolicina"];
                        }
                        ViewHelper::redirect(BASE_URL);
                    }
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
            default:
                break;
        }
    }
    
    public static function predracun() {
        if(isset($_SESSION["id"])) {
            $izdelki = IzdelkiDB::getAll();
        
            $vsota = 0;
            $predracun["izdelki"] = array();
            while ($x = current($_SESSION["cart"])) {
                foreach ($izdelki as $izdelek):
                    if($izdelek["id"] == key($_SESSION["cart"])) {
                        $vsota = $vsota + $x * $izdelek["cena"];
                        $trenutni["ime"] = $izdelek["ime"];
                        $trenutni["cena"] = $izdelek["cena"];
                        $trenutni["kolicina"] = $x;
                        $trenutni["prodajalec"] = $izdelek["prodajalec"];
                        array_push($predracun["izdelki"], $trenutni);
                        break;
                    }
                endforeach;

                next($_SESSION["cart"]);
            }

            $predracun["vsota"] = $vsota;
            echo ViewHelper::render("view/predracun.php", [
                    "predracun" => $predracun
                ]);
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
        
    
