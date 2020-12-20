<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Seznam vaših naročil</title>

<h1>Seznam vaših naročil</h1>
<a href="<?= BASE_URL . "" ?>">Pojdi na začetno stran</a>

<ul>
        <?php
            foreach($narocila as $narocilo):
                echo '<li>';
                echo 'Čas oddaje: ';
                echo $narocilo["cas"];
                echo '</div>';
                echo '<br>';
                //echo number_format($izdelek["cena"] * $izdelek["kolicina"],2);
                echo 'Stanje: ';
                echo $narocilo["stanje"];
                echo '<br> Izdelki: ';
                echo '<ul>';
                    foreach($narocilo["izdelki"] as $izdelek):
                        echo '<div class="izdelek">';
                        echo $izdelek["ime"];
                        echo ' x';
                        echo $izdelek["kolicina"];
                        
                        echo '</div>';
                    endforeach;
                echo '</ul>';
                echo '<div class="cena">';
                echo 'Cena: ';
                echo $narocilo["vsota"];
                echo '</div>';
                echo '</li> <br>';
            endforeach;
        ?>
</ul>

