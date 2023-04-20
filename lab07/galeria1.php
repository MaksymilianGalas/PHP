<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
<?php
$imgDir = "./image";
$dir = scandir($imgDir);
array_shift($dir);
$count = count($dir);
$imgId=0;
$imgName = $dir["$imgId"];


?>

<div>
    <?php
    for($i =1; $i < $count; $i++) {
        $imgName = $dir["$imgId"+$i];
        echo "<img src =\"$imgDir/$imgName\" alt=\"$imgName\" style=height:200px; />";
    }
    ?>


</div>
</body>
</html>