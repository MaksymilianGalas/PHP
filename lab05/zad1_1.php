<?php
function dodawanie($liczba1, $liczba2){
    $wynik = $liczba1 + $liczba2;
    return $wynik;
}
function odejmowanie($liczba1, $liczba2){
    $wynik = $liczba1 - $liczba2;
    return $wynik;
}
function mnozenie($liczba1, $liczba2){
    $wynik = $liczba1 * $liczba2;
    return $wynik;
}
function dzielenie($liczba1, $liczba2){
    if($liczba2 == 0){
        echo 'nie dzielimy przez 0';
    }else {
        $wynik = $liczba1 / $liczba2;
        return $wynik;
    }
}