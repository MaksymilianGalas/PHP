<?php
$liczba1 = $_GET['liczba1'];
$liczba2 = $_GET['liczba2'];
$dzialanie = $_GET['dzialanie'];

switch ($dzialanie) {
    case 'dodawanie':
        $wynik = $liczba1 + $liczba2;
        break;
    case 'odejmowanie':
        $wynik = $liczba1 - $liczba2;
        break;
    case 'mnozenie':
        $wynik = $liczba1 * $liczba2;
        break;
    case 'dzielenie':
        if($liczba2 == 0){
            echo "nie mozna dzielic przez zero";
            break;
        }
        $wynik = $liczba1 / $liczba2;
        break;
}
echo $wynik ?? "";
?><?php
