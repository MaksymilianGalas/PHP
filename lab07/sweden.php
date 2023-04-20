<?php
$obraz = imagecreatetruecolor(302, 202);


$tlo = imagecolorallocate($obraz, 0, 85, 164);
imagefill($obraz, 0, 0, $tlo);


$zolty = imagecolorallocate($obraz, 255, 204, 0);


imagefilledrectangle($obraz, 131, 1, 87, 200, $zolty);


imagefilledrectangle($obraz, 1, 80, 300, 120, $zolty);


header('Content-Type: image/png');
imagepng($obraz);


imagedestroy($obraz);
?>
