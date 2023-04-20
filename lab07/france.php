<?php

$obraz = imagecreatetruecolor(302, 202);

$tlo = imagecolorallocate($obraz, 0, 0, 0);
imagefill($obraz, 0, 0, $tlo);


$niebieski = imagecolorallocate($obraz, 0, 85, 164);
$bialy = imagecolorallocate($obraz, 255, 255, 255);
$czerwony = imagecolorallocate($obraz, 239, 65, 53);


imagefilledrectangle($obraz, 1, 1, 100, 200, $niebieski);


imagefilledrectangle($obraz, 101, 1, 200, 200, $bialy);


imagefilledrectangle($obraz, 201, 1, 300, 200, $czerwony);


header('Content-Type: image/png');
imagepng($obraz);


imagedestroy($obraz);

