<?php

if (isset($_SESSION["id"])) {
   
    echo ' <p> Pozdravljen ' . $_SESSION["ime"] . ', Vaše naročilo je bilo uspešno oddano. </p> ';
    echo ' <p> Status vašega naročila si laho ogledate <a href="' . BASE_URL . "seznamNarocil" . '">tukaj.</a> </p> ';
    
    ?>
    <form action="<?= BASE_URL . "cart" ?>" method="post">
                <input type="hidden" name="do" value="purge_cart">
                 <p> Z nakupom lahko nadaljujete <input href="izdelki" type="submit" value="tukaj."></p> 
    </form> <?php
    
    //echo ' <p> Z nakupom lahko nadaljujete <a href="' . BASE_URL . "izdelki" . '">tukaj.</a> </p> ';
}
else{
    echo '<p> Ni dostopa do te strani! </p>';
}
