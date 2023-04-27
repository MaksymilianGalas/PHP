<?php
// Klasa Walka Pokemon
class Walka {
    public $pokemon1;
    public $pokemon2;
    public $currentPlayer;

    public function __construct($pokemon1, $pokemon2) {
        $this->pokemon1 = $pokemon1;
        $this->pokemon2 = $pokemon2;
        $this->currentPlayer = $pokemon1;
    }

    public function go() {
        while($this->pokemon1->hp_aktualne > 0 && $this->pokemon2->hp_aktualne > 0) {
            echo "<b>{$this->currentPlayer->nazwa}</b> atakuje!<br>";
            $this->currentPlayer->attack($this->getOpponent());
            $this->switchPlayer();
        }
        $winner = $this->getWinner();
        echo "<br><b>{$winner->nazwa} wygrywa walkę!</b>";
    }

    private function getOpponent() {
        return $this->currentPlayer === $this->pokemon1 ? $this->pokemon2 : $this->pokemon1;
    }

    private function switchPlayer() {
        $this->currentPlayer = $this->getOpponent();
    }

    private function getWinner() {
        return $this->pokemon1->hp_aktualne > 0 ? $this->pokemon1 : $this->pokemon2;
    }
}