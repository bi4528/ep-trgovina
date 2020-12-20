<?php

if (isset($_SESSION["id"])){
    if(isset($_SESSION["cart"])){
        unset($_SESSION["cart"]);
        echo ' <p> Pozdravljen ' . $_SESSION["ime"] . ', Vaše naročilo je bilo uspešno oddano. </p> ';
        echo ' <p> Status vašega naročila si lahko ogledate <a href="' . BASE_URL . "seznamNarocil" .'">tukaj.</a> </p> ';
        echo ' <p> Z nakupom lahko nadaljujete <a href="' . BASE_URL . "izdelki" . '">tukaj.</a> </p> ';
    }
    else{
        ViewHelper::redirect(BASE_URL);
    }
}
else{
    echo '<p> Ni dostopa do te strani! </p>';
}
