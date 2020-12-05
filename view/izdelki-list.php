<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Šale</title>

<h1>Vse šale</h1>

<p>[
<a href="<?= BASE_URL . "registracija" ?>">Registracija</a> |
<a href="<?= BASE_URL . "prijava" ?>">Prijava</a>
]</p>

<ul>

    <?php foreach ($izdelki as $izdelek): ?>
    <p><b><?= $izdelek["ID"] ?></b>:<b><?= $izdelek["Ime"] ?> </b> : <b><?= $izdelek["Uporabnik"] ?> </b></p>
    <?php endforeach; ?>

</ul>
