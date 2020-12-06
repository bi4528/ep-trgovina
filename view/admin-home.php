<!doctype html>
<html>
    <head>
        <title>Admin home</title>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1>Admin panel:</h1>
        <?php $admin = $admin[0]; ?> 
        <p>
            <a href="<?= BASE_URL . "admin/edit?id=" . $_SESSION["id"] ?>">Uredi svoj profil</a> | 
            <a href="<?= BASE_URL . "edit/password" ?>">Spremeni geslo</a>
        </p>
        <!-- TODO: uredi svoj profil -->
        <h2>Prodajalci:</h2>
        <ul>
            <!-- TODO: lista vseh prodajalcev, edit -->
            <!-- Popravi da prikaze samo prodajalce namesto vseh uporabnikov -->
            [<a href="<?= BASE_URL . "prodajalec/add" ?>">Dodaj novega prodajalca</a>]
            <?php foreach ($prodajalci as $prodajalec): ?>
            <p><?= $prodajalec["ime"] ?> <?= $prodajalec["priimek"] ?> [<a href="<?= BASE_URL . "prodajalec/edit?id=" . $prodajalec["id"] ?>">Uredi</a>]</p>
            <?php endforeach; ?>

        </ul>

    </body>
</html>
