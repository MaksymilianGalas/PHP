<?php
$obraz = imagecreatetruecolor(302, 202);

$tlo = imagecolorallocate($obraz, 0, 0, 0);
imagefill($obraz, 0, 0, $tlo);


$czerwony = imagecolorallocate($obraz, 220, 20, 60);
$bialy = imagecolorallocate($obraz, 255, 255, 255);


imagefilledrectangle($obraz, 1, 1, 300, 100, $bialy);


imagefilledrectangle($obraz, 1, 101, 300, 200, $czerwony);


header('Content-Type: image/png');
imagepng($obraz);


imagedestroy($obraz);
?>
