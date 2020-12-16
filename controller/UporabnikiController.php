<?php

require_once("model/UporabnikDB.php");
require_once("ViewHelper.php");
require_once("view/forms/registracija-form.php");
require_once("view/forms/registracija-prodajalec.php");
require_once("view/forms/prijava-form.php");
require_once("view/forms/password-form.php");
require_once("view/forms/edit-ap.php");
require_once("view/forms/edit-stranka.php");
require_once("controller/IzdelkiController.php");

//TODO: popravi posodabljanje imena pri spremembi: stranka, prodajalec

class UporabnikiController {
    const SALT = '$1$trgovina$';
    
    public static function prijava() {
        if (!isset($_SESSION["id"])) {
            $form = new PrijavaForm("prijava");
            if ($form->validate()) {
                $uporabnik = $form->getValue();
                $email = $uporabnik["email"];
                $geslo = $uporabnik["geslo"];

                $up = UprabnikDB::getup(array("email" => $uporabnik["email"]));

                if ($up != null) {
                    $up = $up[0];
                    if (crypt($geslo, self::SALT) == $up["geslo"]) {
                        if ($up["aktiven"] == 1) {
                            if ($up["vloga"] == "stranka") {
                                session_regenerate_id();
                                $_SESSION["id"] = $up["id"];
                                $_SESSION["vloga"] = $up["vloga"];
                                $_SESSION["ime"] = $up["ime"];
                                ViewHelper::redirect(BASE_URL);

                                ////TEST ENKRIPCIJE GESLA
                                //var_dump($geslo);
                                //$crypted = crypt($geslo, self::SALT);
                                //echo $crypted;
                                //$decr = crypt("adamAmin123", $crypted);
                                //var_dump($crypted);
                                //var_dump($decr);
                            }else {
                                echo "Napaka: Za vašo vlogo je potrebna prijava s certifikatom.";
                                echo '<p>' . '<a href="' . BASE_URL . "prijava/osebje" . '">Kliknite tukaj za varno prijavo.</a>' . '</p>';
                            }
                           
                        }else {
                            echo "Napaka: Uporabnik je neaktiven";
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
        }else {
            ViewHelper::redirect(BASE_URL);
        }
    }
    
    public static function prijavaosebje() {
        $prodajalci = ["janez", "lojze"];
        
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
        
        $cert_data = openssl_x509_parse($client_cert);
        $commonname = $cert_data["subject"]["CN"];
        $emailAddr = $cert_data["subject"]["emailAddress"];
        
        //var_dump($cert_data);
        
        if (!isset($_SESSION["id"])) {
            $form = new PrijavaForm("prijava");
            if ($form->validate()) {
                $uporabnik = $form->getValue();
                $email = $uporabnik["email"];
                $geslo = $uporabnik["geslo"];

                $up = UprabnikDB::getup(array("email" => $uporabnik["email"]));

                if ($up != null) {
                    $up = $up[0];
                    if (crypt($geslo, self::SALT) == $up["geslo"]) {
                        if ($up["aktiven"] == 1) {
                            // preveri ce se en prodajalec vpise z e:p od drugega
                            if ($commonname == "admin" && $up["vloga"] == "admin") {
                                session_regenerate_id();
                                $_SESSION["id"] = $up["id"];
                                $_SESSION["vloga"] = $up["vloga"];
                                $_SESSION["ime"] = $up["ime"];
                                ViewHelper::redirect(BASE_URL . "admin");
                            }elseif(in_array($commonname, $prodajalci) && $up["vloga"] == "prodajalec" && $uporabnik["email"] == $emailAddr) {
                                session_regenerate_id();
                                $_SESSION["id"] = $up["id"];
                                $_SESSION["vloga"] = $up["vloga"];
                                $_SESSION["ime"] = $up["ime"];
                                ViewHelper::redirect(BASE_URL . "prodajalec");
                            }else {
                                echo "Napaka: Napačen email ali geslo";
                                echo '<p>' . '<a href="' . BASE_URL . "prijava/osebje" . '">Poskusi ponovno</a>' . '</p>';
                            }
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
        }else {
            ViewHelper::redirect(BASE_URL);
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
                $uporabnik["geslo"] = crypt($uporabnik["geslo"], self::SALT);
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
            $form = new PasswordForm("geslo");
            if($form->validate()) {
                $uporabnik = $form->getValue();
                //var_dump($uporabnik);
                $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]));
                $trenutnoGeslo = $trenutnoGeslo[0]["geslo"];
                if (crypt($uporabnik["geslozdaj"], self::SALT) == $trenutnoGeslo) {
                    $parametri["geslo"] = crypt($uporabnik["geslo"], self::SALT);
                    $parametri["id"] = $_SESSION["id"];
                    UprabnikDB::changePassword($parametri);
                    echo "Vaše geslo je bilo uspešno spremenjeno!";
                    echo '<p>' . '<a href="' . BASE_URL . '">Nazaj na prvo stran</a>' . '</p>';
                }else {
                    echo "Napaka: Vnesli ste napačno geslo.";
                    echo '<p>' . '<a href="' . BASE_URL . "admin/edit/password" . '">Poskusi ponovno</a>' . '</p>';
                }
            }else {
                echo ViewHelper::render("view/geslo.php", [
                   "form" => $form 
                ]);
            }
        }else {
            ViewHelper::redirect(BASE_URL . 'prijava');
        }
    }
    
    public static function addprodajalec() {
        if(isset($_SESSION["vloga"]) && $_SESSION["vloga"] == "admin") {
            $form = new RegistracijaFormProdajalec("registracija");
            if($form->validate()) {
                $uporabnik = $form->getValue();
                $uporabnik["vloga"] = "prodajalec";
                $uporabnik["aktiven"] = 1;
                $uporabnik["naslov"] = "";
                $uporabnik["geslo"] = crypt($uporabnik["geslo"], self::SALT);
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
        }else {
            echo "Nepooblaščen dostop";
        }
    }
    
    public static function adminview() {
        unset($_SESSION["id2edit"]);
        //var_dump($_SESSION);
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
    
    public static function editAdmin() {
        if (isset($_SESSION["id"])) {
            if ($_SESSION["vloga"] == "admin") {
                $form = new EditFormAP("uredi");
                if($form->validate()) {
                    $uporabnik = $form->getValue();
                    $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]))[0]["geslo"];
                    
                    if (crypt($uporabnik["geslo"], self::SALT) == $trenutnoGeslo) {
                        $parametri["ime"] = $uporabnik["ime"];
                        $parametri["priimek"] = $uporabnik["priimek"];
                        $parametri["email"] = $uporabnik["email"];
                        $parametri["naslov"] = "";
                        $parametri["id"] = $_SESSION["id"];

                        UprabnikDB::updateAttributes($parametri);
                        $_SESSION["ime"] = $parametri["ime"];
                        echo "Atributi so bili uspešno posodobljeni.";
                        echo '<p>' . '<a href="' . BASE_URL . "admin" . '">Nazaj na admin panel</a>' . '</p>';

                    }else {
                        echo "Napaka: Vnesli ste napačno geslo.";
                        echo '<p>' . '<a href="' . BASE_URL . "admin/edit" . '">Poskusi ponovno</a>' . '</p>';
                    }
                }else {
                    $atributi = UprabnikDB::getAttributes(array("id" => $_SESSION["id"]));
                    $atributi = $atributi[0];
                    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                        "ime" => $atributi["ime"],
                        "priimek" => $atributi["priimek"],
                        "email" => $atributi["email"],
                    )));

                    echo ViewHelper::render("view/uredi.php", [
                       "form" => $form
                    ]);
                }
            }else {
                echo "Nepooblaščen dostop";
            }
            
        }else {
            echo "Nepooblaščen dostop";
        }
    }
    
    public static function editProdajalec() {
        if (isset($_SESSION["id"])) {
            if ($_SESSION["vloga"] == "prodajalec") {
                $form = new EditFormAP("uredi");
                if($form->validate()) {
                    $uporabnik = $form->getValue();
                    $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]))[0]["geslo"];
                    
                    if (crypt($uporabnik["geslo"], self::SALT) == $trenutnoGeslo) {
                        $parametri["ime"] = $uporabnik["ime"];
                        $parametri["priimek"] = $uporabnik["priimek"];
                        $parametri["email"] = $uporabnik["email"];
                        $parametri["naslov"] = "";
                        $parametri["id"] = $_SESSION["id"];

                        UprabnikDB::updateAttributes($parametri);
                        $_SESSION["ime"] = $parametri["ime"];
                        echo "Atributi so bili uspešno posodobljeni.";
                        echo '<p>' . '<a href="' . BASE_URL . "prodajalec" . '">Nazaj na prodajalec panel</a>' . '</p>';

                    }else {
                        echo "Napaka: Vnesli ste napačno geslo.";
                        echo '<p>' . '<a href="' . BASE_URL . "prodajalec/edit" . '">Poskusi ponovno</a>' . '</p>';
                    }
                }else {
                    $atributi = UprabnikDB::getAttributes(array("id" => $_SESSION["id"]));
                    $atributi = $atributi[0];
                    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                        "ime" => $atributi["ime"],
                        "priimek" => $atributi["priimek"],
                        "email" => $atributi["email"]
                    )));

                    echo ViewHelper::render("view/uredi.php", [
                       "form" => $form
                    ]);
                }
            }else {
                echo "Nepooblaščen dostop";
            }
            
        }else {
            echo "Nepooblaščen dostop";
        }
    }
    
    public static function editStranka() {
        if (isset($_SESSION["id"])) {
            if ($_SESSION["vloga"] == "stranka") {
                $form = new EditFormStranka("uredi");
                if($form->validate()) {
                    $uporabnik = $form->getValue();
                    $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]))[0]["geslo"];
                    
                    if (crypt($uporabnik["geslo"], self::SALT) == $trenutnoGeslo) {
                        $parametri["ime"] = $uporabnik["ime"];
                        $parametri["priimek"] = $uporabnik["priimek"];
                        $parametri["naslov"] = $uporabnik["naslov"];
                        $parametri["email"] = $uporabnik["email"];
                        $parametri["id"] = $_SESSION["id"];

                        UprabnikDB::updateAttributes($parametri);
                        $_SESSION["ime"] = $parametri["ime"];
                        echo "Atributi so bili uspešno posodobljeni.";
                        echo '<p>' . '<a href="' . BASE_URL . "izdelki" . '">Nazaj na začetno stran</a>' . '</p>';

                    }else {
                        echo "Napaka: Vnesli ste napačno geslo.";
                        echo '<p>' . '<a href="' . BASE_URL . "stranka/edit" . '">Poskusi ponovno</a>' . '</p>';
                    }
                }else {
                    $atributi = UprabnikDB::getAttributes(array("id" => $_SESSION["id"]));
                    $atributi = $atributi[0];
                    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                        "ime" => $atributi["ime"],
                        "priimek" => $atributi["priimek"],
                        "naslov" => $atributi["naslov"],
                        "email" => $atributi["email"]
                    )));

                    echo ViewHelper::render("view/uredi.php", [
                       "form" => $form
                    ]);
                }
            }else {
                echo "Nepooblaščen dostop";
            }
            
        }else {
            echo "Nepooblaščen dostop";
        }
    }
    
    public static function editAdminProdajalec() {
        $form = new EditFormAP("uredi");
        if($form->validate()) {
            //var_dump($_SESSION["id2edit"]);
            $uporabnik = $form->getValue();
            $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]))[0]["geslo"];

            if (crypt($uporabnik["geslo"], self::SALT) == $trenutnoGeslo) {
                $parametri["ime"] = $uporabnik["ime"];
                $parametri["priimek"] = $uporabnik["priimek"];
                $parametri["email"] = $uporabnik["email"];
                $parametri["naslov"] = "";
                $parametri["id"] = $_SESSION["id2edit"];

                UprabnikDB::updateAttributes($parametri);
                echo "Atributi so bili uspešno posodobljeni.";
                echo '<p>' . '<a href="' . BASE_URL . "admin" . '">Nazaj na admin panel</a>' . '</p>';

            }else {
                echo "Napaka: Vnesli ste napačno geslo.";
                echo '<p>' . '<a href="' . BASE_URL . "admin/edit-prodajalec" . '">Poskusi ponovno</a>' . '</p>';
            }
        }else {
            if (isset($_SESSION["id2edit"])) {
                $atributi = UprabnikDB::getAttributes(array("id" => $_SESSION["id2edit"]));
                $atributi = $atributi[0];
            }else {
                $atributi = UprabnikDB::getAttributes(array("id" => $_POST["id"]));
                $atributi = $atributi[0];
                $_SESSION["id2edit"] = $_POST["id"];
            }
            
            if ($atributi["vloga"] == "prodajalec"){
                $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                    "ime" => $atributi["ime"],
                    "priimek" => $atributi["priimek"],
                    "email" => $atributi["email"]
                )));

                echo ViewHelper::render("view/uredi.php", [
                   "form" => $form
                ]);
            }else {
                echo "Nepooblaščeni dostop.";
            }
        }
    }
    
    public static function editProdajalecStranka() {
        $form = new EditFormStranka("uredi");
        if($form->validate()) {
            //var_dump($_SESSION["id2edit"]);
            $uporabnik = $form->getValue();
            $trenutnoGeslo = UprabnikDB::getPassword(array("id" => $_SESSION["id"]))[0]["geslo"];

            if (crypt($uporabnik["geslo"], self::SALT) == $trenutnoGeslo) {
                $parametri["ime"] = $uporabnik["ime"];
                $parametri["priimek"] = $uporabnik["priimek"];
                $parametri["email"] = $uporabnik["email"];
                $parametri["naslov"] = $uporabnik["naslov"];
                $parametri["id"] = $_SESSION["id2edit"];

                UprabnikDB::updateAttributes($parametri);
                echo "Atributi so bili uspešno posodobljeni.";
                echo '<p>' . '<a href="' . BASE_URL . "prodajalec" . '">Nazaj na admin panel</a>' . '</p>';

            }else {
                echo "Napaka: Vnesli ste napačno geslo.";
                echo '<p>' . '<a href="' . BASE_URL . "prodajalec/edit-stranka" . '">Poskusi ponovno</a>' . '</p>';
            }
        }else {
            if (isset($_SESSION["id2edit"])) {
                $atributi = UprabnikDB::getAttributes(array("id" => $_SESSION["id2edit"]));
                $atributi = $atributi[0];
            }else {
                $atributi = UprabnikDB::getAttributes(array("id" => $_POST["id"]));
                $atributi = $atributi[0];
                $_SESSION["id2edit"] = $_POST["id"];
            }
            
            if ($atributi["vloga"] == "stranka"){
                $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                    "ime" => $atributi["ime"],
                    "priimek" => $atributi["priimek"],
                    "email" => $atributi["email"],
                    "naslov" => $atributi["naslov"]
                )));

                echo ViewHelper::render("view/uredi.php", [
                   "form" => $form
                ]);
            }else {
                echo "Nepooblaščeni dostop.";
            }
        }
    }
    
    public static function prodajalecview() {
        unset($_SESSION["id2edit"]);
        //var_dump($_SESSION);
        if (isset($_SESSION["id"])) {
            if ($_SESSION["vloga"] == "prodajalec") {
                $izdelki = IzdelkiDB::getIzdelkiProdajalec();
                $narocila = IzdelkiController::seznamNeobdelanihNarocil();
                //var_dump($narocila);
                $narocilaPotrjena = IzdelkiController::seznamPotrjenihNarocil();
                $narocilaStornirana = IzdelkiController::seznamStorniranihNarocil();
                //var_dump($narocilaPotrjena);
                echo ViewHelper::render("view/prodajalec-home.php", [
                        "stranke" => UprabnikDB::getStranke(),
                        "izdelki" => $izdelki,
                        "narocila" => $narocila,
                        "narocilaPotrjena" => $narocilaPotrjena,
                        "narocilaStornirana" => $narocilaStornirana
                    ]);
            }else {
                echo "Nepooblaščen dostop";
            }
        }else {
            ViewHelper::redirect(BASE_URL . 'prijava');
        }
    }
    
    public static function aktiviraj() {
        // VARNOST: Admin lahko deaktivira le prodajalca
        //          Prodajalec pa le stranke
        $atributi = UprabnikDB::getAttributes(array("id" => $_POST["id"]));
        $atributi = $atributi[0];
        if ($atributi["aktiven"] == 1) {
            $parametri["aktiven"] = 0;
        }else {
            $parametri["aktiven"] = 1;
        }
        $parametri["id"] = $_POST["id"];
        
        if ($_SESSION["vloga"] == "admin") {
            if ($atributi["vloga"] == "prodajalec"){
                UprabnikDB::changeAktiven($parametri);
                IzdelkiDB::changeAktivenProdajalec($parametri);
                ViewHelper::redirect(BASE_URL . 'admin');
            }else{
                echo "Nepooblaščen dostop";
            }
        }elseif ($_SESSION["vloga"] == "prodajalec") {
            if ($atributi["vloga"] == "stranka"){
                UprabnikDB::changeAktiven($parametri);
                ViewHelper::redirect(BASE_URL . 'prodajalec');
            }else{
                echo "Nepooblaščen dostop";
            }
        }else {
            echo "Nepooblaščen dostop.";
        }
        
    }
    
    public static function preklicNarocila() {
         
        if ($_SESSION["vloga"] == "prodajalec") {
            NarocilaDB::updatePreklic(array("id" => $_POST["id"]));
            ViewHelper::redirect(BASE_URL . 'prodajalec');
        }else {
            echo "Nepooblaščen dostop.";
        }
        
    }
    
    public static function potrditevNarocila() {
         
        if ($_SESSION["vloga"] == "prodajalec") {
            NarocilaDB::updatePotrditev(array("id" => $_POST["id"]));
            ViewHelper::redirect(BASE_URL . 'prodajalec');
        }else {
            echo "Nepooblaščen dostop.";
        }
        
    }
    
    public static function storniranjeNarocila() {
         
        if ($_SESSION["vloga"] == "prodajalec") {
            NarocilaDB::updateStorniranje(array("id" => $_POST["id"]));
            ViewHelper::redirect(BASE_URL . 'prodajalec');
        }else {
            echo "Nepooblaščen dostop.";
        }
        
    }
    
    public static function index() {
        
    }
    //(ime, priimek, naslov, email, geslo, vloga, aktiven)
    public static function getRules() {
        return [
            'ime' => FILTER_SANITIZE_SPECIAL_CHARS,
            'priimek' => FILTER_SANITIZE_SPECIAL_CHARS,
            'naslov' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_SPECIAL_CHARS,
            'geslo' => FILTER_SANITIZE_SPECIAL_CHARS,
            'vloga' => FILTER_SANITIZE_SPECIAL_CHARS,
            'aktiven' =>FILTER_VALIDATE_INT
            
        ];}
        
        public static function checkValues($input) {
        if (empty($input)) {
            
            return FALSE;
        }
        //echo ViewHelper::renderJSON($input, 400);
        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }

}
