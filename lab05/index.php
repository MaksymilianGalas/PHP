<?php
$tablica = array_map('str_getcsv', file('pages.csv'));

$link = $_GET['link'] ?? '';

$podstrona = null;
foreach ($tablica as $p) {
    if ($p[1] == $link) {
        $podstrona = $p;
        break;
    }
}

foreach ($tablica as $p) {
    echo '<li><a href="?link=' . $p[1] . '">' . $p[0] . '</a></li>';
}

if ($podstrona) {
    echo '<b>' . $podstrona[0] . '</b>';
    echo '<br><br>';
    echo $podstrona[2];
} else {
    echo '<b><p>Strona Glowna</p></b>';
}

echo '<br><a href="edit.php">Edytuj podstrony</a>';
?>
