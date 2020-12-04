<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Šale</title>

<h1>Uredi šalo</h1>

<p>[
<a href="<?= BASE_URL . "jokes" ?>">Vse šale</a> |
<a href="<?= BASE_URL . "jokes/add" ?>">Dodaj šalo</a>
]</p>

<form action="<?= BASE_URL . "jokes/edit" ?>" method="post">
    <input type="hidden" name="id" value="<?= $joke["id"] ?>" />
    Datum: <input type="text" name="joke_date" value="<?= $joke["joke_date"] ?>" /><br />
    <textarea rows="8" cols="60" name="joke_text"><?= $joke["joke_text"] ?></textarea><br />
    <p><button>Update record</button></p>
</form>

<form action="<?= BASE_URL . "jokes/delete" ?>" method="post">
    <input type="hidden" name="id" value="<?= $joke["id"] ?>"  />
    <label>Delete? <input type="checkbox" name="delete_confirmation" /></label>
    <button type="submit" class="important">Delete record</button>
</form>
