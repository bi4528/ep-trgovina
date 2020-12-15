<!doctype html>
<html>
    <head>
        <title>Prodajalec home</title>
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
            <p><a href="<?= BASE_URL . "prodajalec/edit" ?>">Uredi svoj profil</a> | 
            <a href="<?= BASE_URL . "edit/password" ?>">Spremeni geslo</a>
        </p>
        <h2>Naročila:</h2>
        <h3>Neobdelana naročila:</h3>
        
        <h3>Potrjena naročila:</h3>
        
        <h3>Stornirana naročila:</h3>
        
        <h2>Moji izdelki:</h2>
        
        <ul>
            [<a href="<?= BASE_URL . "izdelki/add" ?>">Dodaj nov izdelek</a>]
            <?php foreach ($izdelki as $izdelek): ?>
            <p>
                <li><?= $izdelek["ime"] ?> <?= $izdelek["opis"] ?> <?= $izdelek["cena"] ?>
                <form action="<?= BASE_URL . "prodajalec/edit-izdelek" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($izdelek["id"]); ?>" />
                <button>Uredi</button>
                </form>
                <form action="<?= BASE_URL . "izdelek/aktiviraj" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($izdelek["id"]); ?>" />
                <?php
                if ($izdelek["aktiven"] == 1) {
                    echo "<button>Deaktviriaj</button>";
                }else {
                     echo "<button>Aktiviraj</button>";
                }
                ?>
                </form>
            </p>
            <?php endforeach; ?>

        </ul>
        
        <h2>Seznam strank:</h2>
        <ul>
            [<a href="<?= BASE_URL . "registracija" ?>">Dodaj novo stranko</a>]
            <?php foreach ($stranke as $stranka): ?>
            <p>
                <?= $stranka["ime"] ?> <?= $stranka["priimek"] ?>
                <form action="<?= BASE_URL . "prodajalec/edit-stranka" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($stranka["id"]); ?>" />
                <button>Uredi</button>
                </form>
                <form action="<?= BASE_URL . "stranka/aktiviraj" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($stranka["id"]); ?>" />
                <?php
                if ($stranka["aktiven"] == 1) {
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
