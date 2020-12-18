<?php

require_once("model/IzdelkiDB.php");
require_once("model/OceneDB.php");
require_once("model/NarocilaDB.php");
require_once("model/SlikeDB.php");
require_once("model/izdelekNarocilaDB.php");
require_once("ViewHelper.php");
require_once("view/forms/izdelek-form.php");

class IzdelkiController {

    public static function izdelkiview() {
        
        $slike = SlikeDB::getAll();
        if(isset($_GET["isc"])) {
            $get = filter_input(INPUT_GET, 'isc', FILTER_SANITIZE_SPECIAL_CHARS);
            if(!empty($get)){
                $izdelki = IzdelkiDB::getIsci(array("isc" => $get));
            }else {
                $izdelki = IzdelkiDB::getAll();
            }
        }else {
            $izdelki = IzdelkiDB::getAll();
        }
        echo ViewHelper::render("view/izdelki-list.php", [
                "izdelki" => $izdelki,
                "slike" => $slike
            ]);
    }
    
    public static function slikeIzdelka($id) {
        $slike = SlikeDB::getAll();
        
        foreach($slike as $key => $slika): 
            if ($slika["izdelek_id"] != $id){
                unset($key);
            }
        endforeach;
        
        return $slika;
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
    
    public static function addSlika() {
        //var_dump($_SESSION);
        
        //$izdelek_id = IzdelekDB::get(array("id" => $_POST["id"]));
        
        if (isset($_SESSION["vloga"]) && $_SESSION["vloga"] == "prodajalec") {
            // Count total files
        $countfiles = count($_FILES['files']['name']);
        //var_dump($countfiles);
        // Prepared statement
        //$query = "INSERT INTO images (name,image) VALUES(?,?)";

        //$statement = self::getConnection()->prepare($query);
            $slika = array();
            $slika["izdelek_id"] = $_POST["id"];
            // Loop all files
            for($i=0;$i<$countfiles;$i++){

              // File name
              $filename = $_FILES['files']['name'][$i];
              //var_dump($filename);
              // Location
              $target_file = '/var/www/html/'.$filename;
              
              // Select file type
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              // file extension
              $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
              $file_extension = strtolower($file_extension);
              
              //var_dump($file_extension);
              //var_dump($target_file);
              //var_dump($_FILES['files']['tmp_name'][$i]);
              // Valid image extension
              $valid_extension = array("png","jpeg","jpg");

              if(in_array($file_extension, $valid_extension)){
                 
                 //Convert
                 $image_base64 = base64_encode(file_get_contents($_FILES['files']['tmp_name'][$i]) );
                 $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
                 
                 //var_dump($image);
                 //var_dump($_POST["id"]);
                 
                 $slika["slika"] = $image;
                 SlikeDB::insert($slika);
                 
                 ViewHelper::redirect(BASE_URL . 'prodajalec');
                 // Upload file
                 //$moved = move_uploaded_file($_FILES['files']['tmp_name'][$i],$target_file);

                    // Execute query
                    //$statement->execute(array($filename,$target_file));

                 /*if( $moved ) {
                    echo "Successfully uploaded";         
                  } else {
                    echo "Not uploaded because of error #".$_FILES["files"]["error"][$i];
                  }*/
              }

            }
            //echo "File upload successfully";
        }else {
            echo "Nepooblaščen dostop";
        }
        
    }
    
    public static function deleteSlika() {
        //var_dump($_POST);
        if($_POST["method"] == "delete"){
            SlikeDB::delete(array("id" => $_POST["id"]));
        }
        ViewHelper::redirect(BASE_URL . 'prodajalec');
    }
    
    public static function addOcena() {
        if (isset($_SESSION["vloga"]) && $_SESSION["vloga"] == "stranka") {
                        
        }
    }
    
    public static function editIzdelek() {
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

                $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
                    "ime" => $atributi["ime"],
                    "opis" => $atributi["opis"],
                    "cena" => $atributi["cena"]
                )));

                echo ViewHelper::render("view/uredi.php", [
                   "form" => $form
                ]);
            }
        }
        
    }
    
    public static function aktiviraj() {
        $atributi = IzdelkiDB::getAttributes(array("id" => $_POST["id"]));
        $atributi = $atributi[0];
        //var_dump($atributi);
        if ($_SESSION["vloga"] == "prodajalec") {
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
        //var_dump($post);
        
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
    
    public static function oddajNarocilo() {
        if(isset($_SESSION["id"])) {
            $izdelki = IzdelkiDB::getAllAtributes();
            //var_dump($izdelki);
            
            $narocilo["kupec_id"] = $_SESSION["id"];
            NarocilaDB::insert($narocilo);
            
            $narocilo_id = NarocilaDB::lastInsertId();
            //$narocilo_id = mysql_insert_id();
            //var_dump($narocilo_id);
            if(!isset($_SESSION["cart"])){
                echo ViewHelper::redirect(BASE_URL);
            }
            while ($x = current($_SESSION["cart"])) {
                foreach ($izdelki as $izdelek):
                    if($izdelek["id"] == key($_SESSION["cart"])) {
                        
                        $izdelekNarocila["narocilo_id"] = $narocilo_id;
                        $izdelekNarocila["izdelek_id"] = $izdelek["id"];
                        $izdelekNarocila["steviloIzdelkov"] = $x;
                        
                        izdelekNarocilaDB::insert($izdelekNarocila);
                        
                        break;
                    }
                endforeach;

                next($_SESSION["cart"]);
            }
            //unset($_SESSION["cart"]);
            //NarocilaDB::insert($izdelekNarocila);
            echo ViewHelper::render("view/oddaja.php");
        }else {
            echo "Nepooblaščen dostop";
        }
    }
    
    public static function seznamVsehNarocil() {
        
        $narocila = NarocilaDB::getAll();
        $predracuni = array();
        $predracuniNeobdelani = array();
        foreach ($narocila as $narocilo):
            //if ($narocilo["kupec_id"] == $_SESSION["id"]){
                $predracun["id"] = $narocilo["id"];
                $predracun["kupec_id"] = $narocilo["kupec_id"];
                $kp = NarocilaDB::getImeKupcaById($narocilo);
                //var_dump($kp); problem ker vrača array
                $predracun["kupec_ime"] = $kp[0]["kupec_ime"];
                //var_dump($predracun);
                $predracun["cas"] = $narocilo["cas"];
                $predracun["stanje"] = $narocilo["stanje"];

                $izdelkiNarocila = izdelekNarocilaDB::getIzdelkiByNarocilo($narocilo);


                $vsota = 0;
                $predracun["izdelki"] = array();

                foreach ($izdelkiNarocila as $izdelekNarocila):
                    $izdelek = IzdelkiDB::get($izdelekNarocila);

                    $trenutni["ime"] = $izdelek[0]["ime"];
                    $trenutni["cena"] = $izdelek[0]["cena"];
                    $trenutni["opis"] = $izdelek[0]["opis"];
                    $trenutni["kolicina"] = $izdelekNarocila["steviloIzdelkov"];
                    $vsota = $vsota + $izdelekNarocila["steviloIzdelkov"] * $izdelek[0]["cena"];
                    array_push($predracun["izdelki"], $trenutni);
                    //break;


                endforeach;

                $predracun["vsota"] = $vsota;

                array_push($predracuni, $predracun);

                if($predracun["stanje"] === "neobdelano"){
                    array_push($predracuniNeobdelani, $predracun);
                }
            //}
        endforeach;

        return $predracuni;  
        
    }
    
    public static function seznamNarocil() {
        if(isset($_SESSION["id"])) {
            
            $predracuni = IzdelkiController::seznamVsehNarocil();
            
            foreach($predracuni as $key => $predracun):
                if ($predracun["kupec_id"] != $_SESSION["id"]){
                    unset($predracuni[$key]);
                }
            endforeach;
            
            echo ViewHelper::render("view/seznamNarocil.php", [
                            "narocila" => $predracuni
                        ]);
            
        }else {
            echo "Nepooblaščen dostop";
        }
        
    }
    
    public static function seznamPotrjenihNarocil() {
        
            
        $predracuni = IzdelkiController::seznamVsehNarocil();

        foreach($predracuni as $key => $predracun):
            if ($predracun["stanje"] !== "potrjeno"){
                unset($predracuni[$key]);
            }
        endforeach;
        //var_dump($predracuni);
        return $predracuni;
        
    }
    
    public static function seznamNeobdelanihNarocil() {
        
            
        $predracuni = IzdelkiController::seznamVsehNarocil();

        foreach($predracuni as $key => $predracun):
            if ($predracun["stanje"] !== "neobdelano"){
                unset($predracuni[$key]);
            }
        endforeach;
        //var_dump($predracuni);
        return $predracuni;
        
    }
    
    public static function seznamStorniranihNarocil() {
        
            
        $predracuni = IzdelkiController::seznamVsehNarocil();

        foreach($predracuni as $key => $predracun):
            if (($predracun["stanje"] !== "stornirano") && ($predracun["stanje"] !== "preklicano")){
                unset($predracuni[$key]);
            }
        endforeach;
        //var_dump($predracuni);
        return $predracuni;
        
    }
    
        public static function getRules() {
        return [
            'ime' => FILTER_SANITIZE_SPECIAL_CHARS,
            'opis' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cena' => FILTER_VALIDATE_FLOAT,
            'prodajalec_id' => FILTER_SANITIZE_SPECIAL_CHARS,
            'aktiven' =>FILTER_VALIDATE_INT
            
        ];}
        
        public static function checkValues($input) {
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
        
    
