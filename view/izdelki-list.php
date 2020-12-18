<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Začetna stran</title>

<h1>Začetna stran</h1>

<?php
if (isset($_SESSION["id"])) {
    echo '<p>';
    echo 'Pozdravljen, ' . $_SESSION["ime"] . ' | ';
    if($_SESSION["vloga"] == "stranka") {
        echo '<a href="' . BASE_URL . "stranka/edit" . '">Uredi profil</a> | ';
        echo '<a href="' . BASE_URL . "edit/password" . '">Spremeni geslo</a> | ';
        echo '<a href="' . BASE_URL . "seznamNarocil" . '">Seznam narocil</a> | ';
    }
    echo'<a href="' . BASE_URL . "odjava" . '">Odjava</a> | ';
    echo '</p>';
    if ($_SESSION["vloga"] == "admin") {
        echo '<p>';
        echo'<a href="' . BASE_URL . "admin" . '">Admin portal</a>'; 
        echo '</p>';
    }elseif($_SESSION["vloga"] == "prodajalec") {
        echo '<p>';
        echo'<a href="' . BASE_URL . "prodajalec" . '">Prodajalec portal</a>'; 
        echo '</p>';
    }
}else {
    echo '<p>';
    echo 'Pozdravljen, anonimni uporabnik | ';
    echo'<a href="' . BASE_URL . "registracija" . '">Registracija</a> | ';
    echo'<a href="' . BASE_URL . "prijava" . '">Prijava</a> | ';
    echo'<a href="' . BASE_URL . "prijava/osebje" . '">Prijava za osebje</a>';
    echo '</p>';
}

?>

<p>
<form action="<?php BASE_URL ?>" method="get">
    Išči izdelke: <input type="text" name="isc">
</form>
</p>

<ul>

    <?php
        if (empty($izdelki)) {
            echo "Noben izdelek ne ustreza vašemu iskanju.";
        }
    ?>
    
    <?php foreach ($izdelki as $izdelek): ?>
    <div class="izdelek">
        <form action="<?= BASE_URL . "cart" ?>" method="post">
            <input type="hidden" name="do" value="add_into_cart" />
            <input type="hidden" name="id" value="<?= $izdelek["id"] ?>" />
            <div class="ime"><?= $izdelek["ime"] ?></div>
            <div> <?php foreach($slike as $slika): 
                    if ($slika["izdelek_id"] == $izdelek["id"]){?>
                <img src="<?= $slika["slika"]?>" height="80">
                <?php
                } endforeach; ?> </div> 
            <div class="opis"><?= $izdelek["opis"] ?></div>
            <div class="cena"><?= number_format($izdelek["cena"], 2)?> EUR</div>
            <form action="<?= BASE_URL . "izedlki/ocena" ?>" method="post">
                <input type="number" name="ocena" value="" min="0" />
                <button type="submit">Oceni</button>
            </form>
            <button type="submit">V košarico</button>
        </form>
    </div>
    <br>
    <?php endforeach; ?>
    
    <div class="cart">
        <h3>Košarica</h3>
        <p>
            <?php
            if(isset($_SESSION["cart"])) {
                //var_dump($_SESSION["cart"]);
                $vsota = 0;
                
                while ($x = current($_SESSION["cart"])) {
                    
                    foreach ($izdelki as $izdelek):
                        if($izdelek["id"] == key($_SESSION["cart"])) {
                            echo $izdelek["ime"];
                            $vsota = $vsota + $x * $izdelek["cena"];
                            $trenutna = $izdelek["id"];
                            break;
                        }
                    endforeach;
                    echo '<form action="' . BASE_URL . "cart" . '" method="post">';
                        echo '<input type="number" name="kolicina" value="' . $x . '" min="0" />';
                        echo '<input type="hidden" name="do" value="updt" />';
                        echo '<input type="hidden" name="id" value="' . $trenutna . '" />';
                        echo '<button type="submit">Posodobi</button>';
                    echo '</form>';

                next($_SESSION["cart"]);
                }
                
                if($vsota == 0){
                    unset($_SESSION["cart"]);
                    echo "Košarica je prazna";
                }
                else{
                    echo "<p>";
                    echo "Skupaj: <b>" . number_format($vsota,2) . " EUR</b>";
                    echo "</p>";
                }
            }else {
                echo "Košarica je prazna";
            }
            ?>
        <p>
            <form action="<?= BASE_URL . "cart" ?>" method="post">
                <input type="hidden" name="do" value="purge_cart">
                <button type="submit">Izprazni košarico</button>
            </form>
            <?php
            if(isset($_SESSION["cart"]) && isset($_SESSION["id"])) {
                echo '<a href="' . BASE_URL . 'predracun' . '">Zaključi nakup</a>';
            }
            ?>
        </p>
    </div>

</ul>
