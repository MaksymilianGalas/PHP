<?php
// require 'samochod.php';
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
        $samochody[] = new samochod($id, $marka, $model, $rok, $cena, $pojemnosc, $zdjecie);
    }
    fclose($plik);
}

?>

<html>
<body>
<?php foreach($samochody as $samochod): ?>
    <a href="samochod.php?id=<?php echo $samochod->getId() ?>">
        <img src="<?php echo $samochod->getZdjecie() ?>" alt="<?php echo $samochod->getMarka().' '.$samochod->getModel() ?>" width="165">
    </a>
<?php endforeach; ?>
</body>
</html>
