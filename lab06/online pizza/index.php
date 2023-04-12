<?php
require('funkcje.php');
require('dane.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rodzaj = $_POST['rodzaj'];
    $ilosc = $_POST['ilosc'];
    $dodatki = isset($_POST['dodatki']) ? $_POST['dodatki'] : array();

    $cena = oblicz($rodzaj, $ilosc, $dodatki);

    echo 'Cena zamówienia: ' . $cena . ' zł';
    exit;
}
?>

<html>
<head>
    <title>Strona do zamawiania jedzenia online</title>
</head>
<body>
<form method="POST">
    <label for="rodzaj">Rodzaj jedzenia:</label>
    <select name="rodzaj">
        <?php
        global $cennik;
        foreach ($cennik['rodzaje_jedzenia'] as $nazwa => $cena): ?>
            <option value="<?php echo $nazwa ?>"><?php echo $nazwa ?> (<?php echo $cena ?> zł)</option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <label for="dodatki[]">Dodatki:</label>
    <br>
    <?php foreach ($cennik['dodatki'] as $nazwa => $cena): ?>
        <input type="checkbox" name="dodatki[]" value="<?php echo $nazwa ?>"> <?php echo $nazwa ?> (<?php echo $cena ?> zł)<br>
    <?php endforeach; ?>
    <br>
    <label for="ilosc">Ilość:</label>
    <input type="number" name="ilosc" min="1" value="1">
    <br><br>
    <label for="uwagi">Uwagi:</label>
    <br>
    <textarea name="uwagi"></textarea>
    <br><br>
    <input type="submit" value="Zamów">
</form>
</body>
</html>
