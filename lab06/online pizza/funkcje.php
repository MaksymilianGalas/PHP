<?php
require('dane.php');

function oblicz($rodzaj, $ilosc, $dodatki) {
    global $cennik;

    $cena_jedzenia = $cennik['rodzaje_jedzenia'][$rodzaj] * $ilosc;
    $cena_dodatkow = 0;

    foreach ($dodatki as $dodatek) {
        $cena_dodatkow += $cennik['dodatki'][$dodatek];
    }
    $cena_dodatkow = $cena_dodatkow * $ilosc;
    return $cena_jedzenia + $cena_dodatkow;
}
?>
