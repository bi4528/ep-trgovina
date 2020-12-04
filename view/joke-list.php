<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Šale</title>

<h1>Vse šale</h1>

<p>[
<a href="<?= BASE_URL . "registracija" ?>">Registracija</a> |
<a href="<?= BASE_URL . "prijava" ?>">Prijava</a>
]</p>

<p>[
<a href="<?= BASE_URL . "jokes" ?>">Vse šale</a> |
<a href="<?= BASE_URL . "jokes/add" ?>">Dodaj šalo</a>
]</p>

<ul>

    <?php foreach ($jokes as $joke): ?>
    <p><b><?= $joke["joke_date"] ?></b>: <?= $joke["joke_text"] ?> [<a href="<?= BASE_URL . "jokes/edit?id=" . $joke["id"] ?>">Uredi</a>]</b></p>
    <?php endforeach; ?>

</ul>
