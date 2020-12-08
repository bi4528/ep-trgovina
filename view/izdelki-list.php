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
    echo'<a href="' . BASE_URL . "prijava" . '">Prijava</a>';
    echo '</p>';
}

?>

<ul>

    <?php foreach ($izdelki as $izdelek): ?>
    <p><b><?= $izdelek["ime"] ?></b>:<b><?= $izdelek["opis"] ?> </b> : <b><?= $izdelek["prodajalec"] ?> </b> <b><?= $izdelek["cena"] ?> </b></p>
    <?php endforeach; ?>

</ul>
