<!doctype html>
<html>
    <head>
        <title>Admin home</title>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1>Admin panel:</h1>
        <p>
            <a href="<?= BASE_URL . "admin/edit" ?>">Uredi svoj profil</a> | 
            <a href="<?= BASE_URL . "edit/password" ?>">Spremeni geslo</a> |
            <a href="<?= BASE_URL . "odjava" ?>">Odjava</a>
        </p>
        <h2>Prodajalci:</h2>
        <ul>
            [<a href="<?= BASE_URL . "prodajalec/add" ?>">Dodaj novega prodajalca</a>]
            <?php foreach ($prodajalci as $prodajalec): ?>
            <p>
                <?= $prodajalec["ime"] ?> <?= $prodajalec["priimek"] ?>
                <form action="<?= BASE_URL . "admin/edit-prodajalec" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($prodajalec["id"]); ?>" />
                <button>Uredi</button>
                </form>
            
                <form action="<?= BASE_URL . "prodajalec/aktiviraj" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($prodajalec["id"]); ?>" />
                <?php
                if ($prodajalec["aktiven"] == 1) {
                    echo "<button>Deaktviriaj</button>";
                }else {
                     echo "<button>Aktiviraj</button>";
                }
                ?>
                </form>
            </p>
            <?php endforeach; ?>

        </ul>

    </body>
</html>
