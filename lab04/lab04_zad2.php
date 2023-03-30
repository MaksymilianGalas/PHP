<?php
$tablica = array(
    array('nazwa' => 'O nas', 'link' => 'onas', 'tresc' => 'Witaj na stronie'),
    array('nazwa' => 'Kontakt', 'link' => 'kontakt', 'tresc' => 'Skontaktuj się z nami'),
    array('nazwa' => 'Oferta', 'link' => 'oferta', 'tresc' => 'Zobacz naszą ofertę'),
);

$link = $_GET['link'] ?? ' ';


$podstrona = null;
foreach ($tablica as $p) {
    if ($p['link'] == $link) {
        $podstrona = $p;
        break;
    }
}

foreach ($tablica as $p) {
    echo '<li><a href="?link=' . $p['link'] . '">' . $p['nazwa'] . '</a></li>';
}

if ($podstrona) {
    echo '<b>' . $podstrona['nazwa'] . '</b>';
    echo '<br><br>';
    echo $podstrona['tresc'];
} else {
    echo '<b><p>Strona Glowna</p></b>';
}
