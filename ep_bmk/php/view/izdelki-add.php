<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Dodaj izdelek</title>

<h1>Dodaj izdelek</h1>

<!-- <p>[
<a href="<?= BASE_URL . "jokes" ?>">Vse šale</a> |
<a href="<?= BASE_URL . "jokes/add" ?>">Dodaj šalo</a>
]</p> -->
<?php echo 'Prodajalec: ' . $_SESSION["ime"]; ?>
<form action="<?= BASE_URL . "izdelek/add" ?>" method="post">
    
    Ime izdelka: <input type="text" name="ime" /><br />
    Opis izdelka: <textarea rows="8" cols="60" name="opis"></textarea><br />
    Cena izdelka: <input type="text" name="cena" /><br />
    <input type="hidden" name="prodajalec_id" value="<?= $_SESSION["id"]?>" />
    <input type="hidden" name="aktiven" value="1" />

    <p><button>Insert</button></p>
</form>
