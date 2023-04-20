<!DOCTYPE HTML>
<html>
<head>
</head>

<body>
<?php
$imgDir = "./image/fullsize";
$imgId = 0;
if(isSet($_GET['imgid'])){
    $imgId = $_GET['imgid'];
}
else{
    $imgId = 0;
}

$dir = scandir($imgDir);
array_shift($dir);
array_shift($dir);

$count = count($dir);

if($imgId < 0 || $imgId >= $count || !is_numeric($imgId)){
    $imgId =0;
}
$imgName = $dir["$imgId"];
$first = 0;
$last = $count -1;
if($imgId < $count -1){
    $next = $imgId +1;
}
else{
    $next = $count -1;
}
if($imgId>0){
    $prev = $imgId -1;
}
else{
    $prev = 0;
}

?>
<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<div>
    <?php
    echo "<img src =\"$imgDir/$imgName\" alt=\"$imgName\" style=height:200px; />";        ?>
    <div id='opis' style='text-align:center'>
            <?php
                $imgId++;
                echo "Obraz $imgName ($imgId z $count)";
            ?>
        </div>
        <div id='nawigacja' style='text-align: center';>
            <?php
                echo "<a href=\"galeria.php?imgid=$first\">Pierwszy</a> ";
                echo "<a href=\"galeria.php?imgid=$prev\">Poprzedni</a> ";
                echo "<a href=\"galeria.php?imgid=$next\">Następny</a> ";
                echo "<a href=\"galeria.php?imgid=$last\">Ostatni</a> ";
            ?>
    </div>
</div>
</body>
</html>