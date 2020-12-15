<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Začetna stran</title>

<h1>Začetna stran</h1>

<?php 
    var_dump($narocila);
    foreach ($narocila as $narocilo): ?>
    <table class="narocilo">
        <tr>
            <td>Datum in čas oddaje naročila: <?= $narocilo["cas"] ?> </td>
        </tr>
        <tr>
            <td>Stanje oddanega naročila: <?= $narocilo["stanje"] ?></td>
        </tr>
    </table>
<?php endforeach; ?>

