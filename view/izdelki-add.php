<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Dodaj izdelek</title>

<h1>Dodaj izdelek</h1>

<!-- <p>[
<a href="<?= BASE_URL . "jokes" ?>">Vse šale</a> |
<a href="<?= BASE_URL . "jokes/add" ?>">Dodaj šalo</a>
]</p> -->

<form action="<?= BASE_URL . "izdelki/add" ?>" method="post">
    <!-- <input type="hidden" name="prodajalec_id" value="<?= $izdelek["prodajalec_id"]?>" /> -->
    <input type="hidden" name="aktiven" value="<?= 1?>" />
    Ime izdelka: <input type="text" name="ime_izdelka" /><br />
    Opis izdelka: <textarea rows="8" cols="60" name="opis_izdelka"></textarea><br />
    Cena izdelka: <input type="text" name="cena_izdelka" /><br />
    <p><button>Insert</button></p>
</form>
