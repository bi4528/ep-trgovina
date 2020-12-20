<!doctype html>
<html>
    <head>
        <title>Predračun</title>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
        <meta charset="UTF-8" />
    </head>
    <body>
        <h2>Vaše naročilo:</h2>
        <ul>
            <?php
                if(!isset($_SESSION["cart"])){
                    ViewHelper::redirect(BASE_URL);
                }
                foreach($predracun["izdelki"] as $izdelek):
                    echo '<li>';
                    echo '<div class="izdelek">';
                    echo '<div class="opis">';
                    echo $izdelek["ime"] . ' X ' . $izdelek["kolicina"];
                    echo '</div>';
                    echo '<div class="cena">';
                    echo number_format($izdelek["cena"] * $izdelek["kolicina"],2);
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                endforeach;
            ?>
        </ul>
        <h3>Skupaj za plačilo:</h3>
        <h4><?= number_format($predracun["vsota"], 2) ?> EUR</h4>
        <p>
            <a href="<?= BASE_URL . 'oddaj' ?>">Oddaj naročilo</a>
        </p>
    </body>
</html>
