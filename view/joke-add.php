<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Šale</title>

<h1>Dodaj šalo</h1>

<p>[
<a href="<?= BASE_URL . "jokes" ?>">Vse šale</a> |
<a href="<?= BASE_URL . "jokes/add" ?>">Dodaj šalo</a>
]</p>

<form action="<?= BASE_URL . "jokes/add" ?>" method="post">
    Date: <input type="text" name="joke_date" value="<?= date("Y-m-d") ?>" /><br />
    <textarea rows="8" cols="60" name="joke_text"></textarea><br />
    <p><button>Insert</button></p>
</form>
