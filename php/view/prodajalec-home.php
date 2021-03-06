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
        <ul>
            <?php foreach ($narocila as $narocilo): ?>
            <p>
                <li>Čas oddaje: <?= $narocilo["cas"] ;
                        foreach($narocilo["izdelki"] as $izdelek):
                            echo '<div class="izdelek">';
                            echo $izdelek["ime"];
                            echo ' x';
                            echo $izdelek["kolicina"];

                            echo '</div>';
                        endforeach;
                    ?>
                    <div>Kupec: <?= $narocilo["kupec_ime"] ?></div>
                    <div>Stanje: <?= $narocilo["stanje"] ?></div>
                <form action="<?= BASE_URL . "prodajalec/preklic" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($narocilo["id"]); ?>" />
                <?php echo "<button>Prekliči</button>"; ?>
                </form>
                <form action="<?= BASE_URL . "prodajalec/potrditev" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($narocilo["id"]); ?>" />
                <?php echo "<button>Potrdi</button>"; ?>
                </form>
                
            </p>
            <?php endforeach; ?>

        </ul>
        <h3>Potrjena naročila:</h3>
        <ul>
        <?php foreach ($narocilaPotrjena as $narociloPotrjena): ?>
            <p>
                <li>Čas oddaje: <?= $narociloPotrjena["cas"] ;
                        foreach($narociloPotrjena["izdelki"] as $izdelek):
                            echo '<div class="izdelek">';
                            echo $izdelek["ime"];
                            echo ' x';
                            echo $izdelek["kolicina"];

                            echo '</div>';
                        endforeach;
                    ?>
                    <div>Kupec: <?= $narociloPotrjena["kupec_ime"] ?></div>
                    <div>Stanje: <?= $narociloPotrjena["stanje"] ?></div>
                <form action="<?= BASE_URL . "prodajalec/storniraj" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo strval($narociloPotrjena["id"]); ?>" />
                <?php echo "<button>Storniraj</button>"; ?>
                </form>           
            </p>
            <?php endforeach; ?>
        </ul>
        <h3>Stornirana in preklicana naročila:</h3>
        <ul>
        <?php foreach ($narocilaStornirana as $narociloStornirana): ?>
            <p>
                <li>Čas oddaje: <?= $narociloStornirana["cas"] ;
                        foreach($narociloStornirana["izdelki"] as $izdelek):
                            echo '<div class="izdelek">';
                            echo $izdelek["ime"];
                            echo ' x';
                            echo $izdelek["kolicina"];

                            echo '</div>';
                        endforeach;
                    ?>
                    <div>Kupec: <?= $narociloStornirana["kupec_ime"] ?></div>
                    <div>Stanje: <?= $narociloStornirana["stanje"] ?></div>        
            </p>
            <?php endforeach; ?>
        </ul>
        <h2>Izdelki:</h2>
        
        <ul>
            [<a href="<?= BASE_URL . "izdelki/add" ?>">Dodaj nov izdelek</a>]
            <?php foreach ($izdelki as $izdelek): ?>
            <p>
                <li><?= $izdelek["ime"] ?> <?= $izdelek["opis"] ?> <?= $izdelek["cena"] ?></li> 
                <li style="display: inline;" > <?php foreach($slike as $slika): 
                    if ($slika["izdelek_id"] == $izdelek["id"]){ ?>
                <form action="<?= BASE_URL . "izdelki/slika/delete" ?>" method="post" style="display: inline;">  
                    <input type="hidden" name="id" value="<?php echo $slika["id"]; ?>" />
                    <img src="<?= $slika["slika"]?>" height="80">
                <button>Pobriši</button>
                </form>
                <?php
                } endforeach; ?> </li> 
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
                <form method='post' action='izdelki/slika' enctype='multipart/form-data'>
                    <label>Naloži slike</label>
                    <input type='file' name='files[]' multiple />
                    <input type="hidden" name="id" value="<?php echo strval($izdelek["id"]); ?>" />
                    <input type='submit' value='Pošlji sliko' name='submit' />
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
