<?php
$plik = 'dane.txt';

if(isset($_POST['dane'])) {
    $dane = $_POST['dane'] . "\n";
    $plik_otwarty = fopen($plik, 'a');
    fwrite($plik_otwarty, $dane);
    fclose($plik_otwarty);
    echo 'Dane zostały zapisane do pliku!';
}