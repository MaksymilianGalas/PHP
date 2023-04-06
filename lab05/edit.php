<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array();
    foreach ($_POST as $p) {
        $data[] = array($p['nazwa'], $p['link'], $p['tresc']);
    }
    $fp = fopen('data.csv', 'w');
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
}

$tablica = array_map('str_getcsv', file('pages.csv'));
?>

<form method="POST">
    <?php foreach ($tablica as $p) { ?>
        <label for="<?php echo $p[1]; ?>_nazwa">Nazwa:</label>
        <input type="text" name="<?php echo $p[1]; ?>[nazwa]" id="<?php echo $p[1]; ?>_nazwa" value="<?php echo $p[0]; ?>"><br>
        <label for="<?php echo $p[1]; ?>_link">Link:</label>
        <input type="text" name="<?php echo $p[1]; ?>[link]" id="<?php echo $p[1]; ?>_link" value="<?php echo $p[1]; ?>"><br>
        <label for="<?php echo $p[1]; ?>_tresc">Treść:</label>
        <textarea name="<?php echo $p[1]; ?>[tresc]" id="<?php echo $p[1]; ?>_tresc"><?php echo $p[2]; ?></textarea><br><br>
    <?php } ?>
    <input type="submit" value="Zapisz zmiany">
</form>

