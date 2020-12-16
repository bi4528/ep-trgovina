<?php

if (isset($_SESSION["id"])) {
   
    echo ' <p> Pozdravljen ' . $_SESSION["ime"] . ', Vaše naročilo je bilo uspešno oddano. </p> ';
    ?>
    <form action="<?= BASE_URL . "cart" ?>" method="post">
                <input type="hidden" name="do" value="purge_cart">
                 <p> Status vašega naročila si lahko ogledate <input href="seznamNarocil" type="submit" value="tukaj."></p> 
    </form>
    <form action="<?= BASE_URL . "cart" ?>" method="post">
                <input type="hidden" name="do" value="purge_cart">
                 <p> Z nakupom lahko nadaljujete <input href="izdelki" type="submit" value="tukaj."></p> 
    </form> <?php
    
    //echo ' <p> Z nakupom lahko nadaljujete <a href="' . BASE_URL . "izdelki" . '">tukaj.</a> </p> ';
}
else{
    echo '<p> Ni dostopa do te strani! </p>';
}
