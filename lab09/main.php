<?php
require 'specjalnosc.php';
require 'walka.php';
// Klasa Pokemon
class Pokemon {
    public $nazwa;
    public $rodzaj;
    public $hp_max;
    public $hp_aktualne;
    public $słabość = array();
    public $odporność = array();
    public $is_paralyzed = false;
    public $is_confused = false;

    public function __construct($nazwa, $rodzaj, $hp_max) {
        $this->nazwa = $nazwa;
        $this->rodzaj = $rodzaj;
        $this->hp_max = $hp_max;
        $this->hp_aktualne = $hp_max;
    }

    public function attack($pokemon) {
        if($this->is_paralyzed) {
            echo $this->nazwa . " jest sparaliżowany i nie może atakować!<br>";
            $this->is_paralyzed = false;
            return;
        }

        $damage = 10;
        if(isset($pokemon->odporność[$this->rodzaj])) {
            $damage /= 2;
        }
        if(isset($pokemon->słabość[$this->rodzaj])) {
            $damage *= 2;
        }

        if($this->is_confused) {
            $liczba = rand(0, 1);
            if($liczba) {
                echo $this->nazwa . " atakuje sam siebie!<br>";
                $this->hp_aktualne -= $damage;
                $this->is_confused = false;
                return;
            }
        }

        echo $this->nazwa . " atakuje " . $pokemon->nazwa . " za " . $damage . " punktów obrażeń!<br>";
        $pokemon->hp_aktualne -= $damage;

        if(rand(0, 1)) {
            echo $pokemon->nazwa . " jest sparaliżowany!<br>";
            $pokemon->is_paralyzed = true;
        }
    }

    public function wypisz_pokemon() {
        echo "<div style='background-color: " . $this->rodzaj . "; color: white; padding: 10px;'>";
        echo "<img src='" . $this->nazwa . ".png' width='100'><br>";
        echo $this->nazwa . "<br>";
        echo "HP: " . $this->hp_aktualne . "/" . $this->hp_max . "<br>";
        echo "</div>";
    }
}



$pokemon1 = new Pokemon('Squirtle', 'Ziemia', 50);
$pokemon2 = new Pokemon('Charmander', 'Elektryczny', 45);
$walka = new Walka($pokemon1, $pokemon2);
$walka->go();
?>