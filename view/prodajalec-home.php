<!doctype html>
<html>
    <head>
        <title>Admin home</title>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1>Prodajalec panel:</h1>
        <?php
        echo '<p>';
        echo 'Pozdravljen, ' . $_SESSION["ime"] . ' | ';
        echo'<a href="' . BASE_URL . "odjava" . '">Odjava</a> | ';
        echo '</p>';
        ?>
        <p><a href="<?php /* BASE_URL . "admin/edit?id=" . $admin["id"] */?>">Uredi svoj profil</a></p>
        <h2>Naročila:</h2>
        <h3>Neobdelana naročila:</h3>
        <h3>Oddana naročila:</h3>
        <h3>Potrjena naročila:</h3>
        <h2>Seznam izdelkov:</h2>
        [<a href="<?= BASE_URL . "izdelek/add" ?>">Dodaj nov izdelkov</a>]
        <!-- TODO: prikaz artiklov -->
        <h2>Seznam strank:</h2>
        <ul>
            [<a href="<?= BASE_URL . "stranka/add" ?>">Dodaj novo stranko</a>]
            <?php foreach ($stranke as $stranka): ?>
            <p><?= $stranka["ime"] ?> <?= $stranka["priimek"] ?> [<a href="<?= BASE_URL . "stranka/edit?id=" . $stranka["id"] ?>">Uredi</a>]</p>
            <?php endforeach; ?>

        </ul>

    </body>
</html>
