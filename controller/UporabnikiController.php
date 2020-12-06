<?php

require_once("model/UporabnikDB.php");
require_once("ViewHelper.php");
require_once("view/forms/registracija-form.php");
require_once("view/forms/registracija-prodajalec.php");
require_once("view/forms/prijava-form.php");
require_once("view/forms/password-form.php");


class UporabnikiController {

    public static function prijava() {
        $form = new PrijavaForm("prijava");
        
        if ($form->validate()) {
            $uporabnik = $form->getValue();
            $email = $uporabnik["email"];
            $geslo = $uporabnik["geslo"];
            
            $up = UprabnikDB::getup(array("email" => $uporabnik["email"]));
            
            if ($up != null) {
                $up = $up[0];
                //var_dump($up);
                if ($up["geslo"] == $geslo) {
                    if ($up["aktiven"] == 1) {
                        session_regenerate_id();
                        $_SESSION["id"] = $up["id"];
                        $_SESSION["vloga"] = $up["vloga"];
                        $_SESSION["ime"] = $up["ime"];
                        ViewHelper::redirect(BASE_URL);
                    }else {
                        echo "uporabnik neaktiven";
                    }
                }else {
                    echo "napačno geslo";
                }
            }else {
                echo "uporabnik ne obstaja";
            }
        }else {
            echo ViewHelper::render("view/prijava.php", [
               "form" => $form 
            ]);
        }
    }
    
    public static function odjava() {
        session_regenerate_id();
        session_destroy();
        ViewHelper::redirect(BASE_URL);
    }
    
    public static function add() {
        $form = new RegistracijaForm("registracija");
        if($form->validate()) {
            $uporabnik = $form->getValue();
            $uporabnik["vloga"] = "stranka";
            $uporabnik["aktiven"] = 1;
            $up = UprabnikDB::getup(array("email" => $uporabnik["email"]));
            if ($up == null) {
                UprabnikDB::insert($uporabnik);
                $up = UprabnikDB::getup(array("email" => $uporabnik["email"]));
                $up = $up[0];
                session_regenerate_id();
                $_SESSION["id"] = $up["id"];
                $_SESSION["vloga"] = $up["vloga"];
                $_SESSION["ime"] = $up["ime"];
                ViewHelper::redirect(BASE_URL);
            }else {
                echo 'Uporabnik že obstaja';
            }
            
        }else {
            echo ViewHelper::render("view/registracija.php", [
               "form" => $form 
            ]);
        }
    }
    
    public static function editpassword() {
        if (isset($_SESSION["id"])) {
            $form = new PasswordForm("pass");
            if($form->validate()) {
                $uporabnik = $form->getValue();
                //var_dump($uporabnik);
                $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]));
                $trenutnoGeslo = $trenutnoGeslo[0]["geslo"];
                if ($uporabnik["geslozdaj"] == $trenutnoGeslo) {
                    $parametri["geslo"] = $uporabnik["geslo"];
                    $parametri["id"] = $_SESSION["id"];
                    UprabnikDB::changePassword($parametri);
                    echo "Vaše geslo je bilo uspešno spremenjeno!";
                    echo '<p>' . '<a href="' . BASE_URL . '">Nazaj na prvo stran</a>' . '</p>';
                }else {
                    echo "Napaka: Vnesli ste napačno geslo.";
                    echo '<p>' . '<a href="' . BASE_URL . "admin/edit/password" . '">Poskusi ponovno</a>' . '</p>';

                }
            }else {
                echo ViewHelper::render("view/registracija.php", [
                   "form" => $form 
                ]);
            }
        }else {
            ViewHelper::redirect(BASE_URL . 'prijava');
        }
    }
    
    public static function addprodajalec() {
        $form = new RegistracijaFormProdajalec("registracija");
        if($form->validate()) {
            $uporabnik = $form->getValue();
            $uporabnik["vloga"] = "prodajalec";
            $uporabnik["aktiven"] = 1;
            $uporabnik["naslov"] = "";
            
            $up = UprabnikDB::getup(array("email" => $uporabnik["email"]));
            if ($up == null) {
                UprabnikDB::insert($uporabnik);
                ViewHelper::redirect(BASE_URL . 'admin');
            }else {
                echo 'Uporabnik že obstaja';
            }
            
        }else {
            echo ViewHelper::render("view/registracija.php", [
               "form" => $form 
            ]);
        }
    }
    
    public static function adminview() {    
        if (isset($_SESSION["id"])) {
            if ($_SESSION["vloga"] == "admin") {
                echo ViewHelper::render("view/admin-home.php", [
                        "admin" => UprabnikDB::getAdmin(),
                        "prodajalci" => UprabnikDB::getProdajalci()
                    ]);
            }else {
                echo "Nepooblaščen dostop";
            }
        }else {
            ViewHelper::redirect(BASE_URL . 'prijava');
        }
    }
    
    public static function prodajalecview() {
        if (isset($_SESSION["id"])) {
            if ($_SESSION["vloga"] == "prodajalec") {
                echo ViewHelper::render("view/prodajalec-home.php", [
                        "stranke" => UprabnikDB::getStranke()
                    ]);
            }else {
                echo "Nepooblaščen dostop";
            }
        }else {
            ViewHelper::redirect(BASE_URL . 'prijava');
        }
    }
    
    public static function index() {
        
    }

}
