<?php
include 'zad1_1.php';

$liczba1 = $_GET['liczba1'];
$liczba2 = $_GET['liczba2'];
$dzialanie = $_GET['dzialanie'];

switch ($dzialanie) {
    case 'dodawanie':
        echo dodawanie($liczba1,$liczba2);
        break;
    case 'odejmowanie':
        echo odejmowanie($liczba1,$liczba2);
        break;
    case 'mnozenie':
        echo mnozenie($liczba1,$liczba2);
        break;
    case 'dzielenie':
        echo dzielenie($liczba1,$liczba2);
        break;
}
echo $wynik ?? "";