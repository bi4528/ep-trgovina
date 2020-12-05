<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Začetna stran</title>

<h1>Začetna stran</h1>

<p>[
<a href="<?= BASE_URL . "registracija" ?>">Registracija</a> |
<a href="<?= BASE_URL . "prijava" ?>">Prijava</a>
]</p>

<ul>

    <?php foreach ($izdelki as $izdelek): ?>
    <p><b><?= $izdelek["ime"] ?></b>:<b><?= $izdelek["opis"] ?> </b> : <b><?= $izdelek["prodajalec"] ?> </b> <b><?= $izdelek["cena"] ?> </b></p>
    <?php endforeach; ?>

</ul>
