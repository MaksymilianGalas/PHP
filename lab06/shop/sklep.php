<?php
require_once('function.php');

if(isset($koszyk)) {
    foreach($koszyk as $key => $produkt) {
        // rest of the code for the loop
    }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['dodaj'])) {
    $id = $_GET['dodaj'];
    dodaj($id);
}

if (isset($_POST['akcja']) && $_POST['akcja'] == 'usun') {
    $id = $_POST['id'];
    usun($id);
}

if (isset($_GET['wyczysc'])) {
    wyczysc();

}

$produkty = array();
if (($handle = fopen('produkty.csv', 'r')) !== false) {
    $header = fgetcsv($handle, 0, ';');
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        $produkt = array();
        foreach ($header as $key => $value) {
            $produkt[$value] = $data[$key];
        }
        $produkty[] = $produkt;
    }
    fclose($handle);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sklep internetowy</title>
</head>
<body>
<h1>Sklep internetowy</h1>

<table>
    <thead>
    <tr>
        <th>Nazwa</th>
        <th>Ilość</th>
        <th>Cena</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produkty as $produkt): ?>
        <tr>
            <td><?php echo $produkt['nazwa']; ?></td>
            <td><?php echo $produkt['ilosc']; ?></td>
            <td><?php echo $produkt['cena']; ?> zł</td>
            <td><a href="?dodaj=<?php echo $produkt['id']; ?>">Do koszyka</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Koszyk</h2>

<table>
    <thead>
    <tr>
        <th>Nazwa</th>
        <th>Ilość</th>
        <th>Cena</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($_SESSION['koszyk'] as $id => $ilosc): ?>
        <?php foreach ($produkty as $produkt): ?>
            <?php if ($produkt['id'] == $id): ?>
                <tr>
                    <td><?php echo $produkt['nazwa']; ?></td>
                    <td><?php echo $ilosc; ?></td>
                    <td><?php echo $produkt['cena']; ?> zł</td>
                    <td>
                        <form action="sklep.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="akcja" value="usun">
                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<form action="sklep.php" method="get">
    <button type="submit" name="wyczysc">Wyczyść koszyk</button>
</form>

</body>
</html>
