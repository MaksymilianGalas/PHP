<?php
$obraz = imagecreatetruecolor(302, 202);


$tlo = imagecolorallocate($obraz, 186,12, 47);
imagefill($obraz, 0, 0, $tlo);


$zolty = imagecolorallocate($obraz, 255, 255, 255);
$niebieski = imagecolorallocate($obraz,0, 32, 91);

imagefilledrectangle($obraz, 131, 1, 87, 200, $zolty);
imagefilledrectangle($obraz, 1, 80, 300, 120, $zolty);

imagefilledrectangle($obraz, 121, 1, 97, 200, $niebieski);
imagefilledrectangle($obraz, 1, 90, 300, 110, $niebieski);
header('Content-Type: image/png');
imagepng($obraz);


imagedestroy($obraz);
?>


