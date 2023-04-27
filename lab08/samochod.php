<?php
class Samochod
{
    private $id;
    private $marka;
    private $model;
    private $rok;
    private $cena;
    private $pojemnosc;
    private $zdjecie;

    public function __construct($id, $marka, $model, $rok, $cena, $pojemnosc, $zdjecie)
    {
        $this->id = $id;
        $this->marka = $marka;
        $this->model = $model;
        $this->rok = $rok;
        $this->cena = $cena;
        $this->pojemnosc = $pojemnosc;
        $this->zdjecie = $zdjecie;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMarka()
    {
        return $this->marka;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getRok()
    {
        return $this->rok;
    }
    public function getZdjecie()
    {
        return $this->zdjecie;
    }
    public function getCena()
    {
        return $this->cena;
    }

    public function getPojemnosc()
    {
        return $this->pojemnosc;
    }

    public function getLink()
    {
        return $this->zdjecie;
    }
}

// wczytanie danych z pliku
$plik = fopen('samochody.csv', 'r');
if ($plik) {
    $samochody = [];
    while ($linia = fgetcsv($plik)) {
        $id = $linia[0];
        $marka = $linia[1];
        $model = $linia[2];
        $rok = $linia[3];
        $cena = $linia[4];
        $pojemnosc = $linia[5];
        $zdjecie = $linia[6];
        $samochody[] = new Samochod($id, $marka, $model, $rok, $cena, $pojemnosc, $zdjecie);
    }
    fclose($plik);
}

$samochod_id = $_GET['id'];
$samochod = null;
foreach ($samochody as $s) {
    if ($s->getId() == $samochod_id) {
        $samochod = $s;
        break;
    }
}

echo '<li><a href="samochod.php?id=' . $samochod->getId() . '"><img src="' . $samochod->getZdjecie() . '" width="300"></a></li>';

if ($samochod) {
    echo '<h1>' . $samochod->getMarka() . ' ' . $samochod->getModel() . '</h1>';
    echo '<p>Rok produkcji: ' . $samochod->getRok() . '</p>';
    echo '<p>Cena: ' . $samochod->getCena() . '</p>';
    echo '<p>Pojemność: ' . $samochod->getPojemnosc() . '</p>';
} else {
    echo '<p>Samochód o podanym ID nie istnieje.</p>';
}
