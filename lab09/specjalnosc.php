<?php
// Klasy dziedziczące Pokemon
class Woda extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Woda', $hp_max);
        $this->słabość['Elektryczny'] = true;
        $this->odporność['Ogień'] = true;
    }
}

class Ogień extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Ogień', $hp_max);
        $this->słabość['Woda'] = true;
        $this->odporność['Lód'] = true;
    }
}
class Elektryczny extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Elektryczny', $hp_max);
        $this->słabość['Ziemia'] = true;
        $this->odporność['Latający'] = true;
    }
}

class Trawiasty extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Trawiasty', $hp_max);
        $this->słabość['Ognisty'] = true;
        $this->odporność['Wodny'] = true;
    }
}

class Normalny extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Normalny', $hp_max);
    }
}

class Latający extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Latający', $hp_max);
        $this->słabość['Elektryczny'] = true;
        $this->odporność['Ziemia'] = true;
    }
}
class Ziemi extends Pokemon {
    public function __construct($nazwa, $hp_max) {
        parent::__construct($nazwa, 'Ziemi', $hp_max);
        $this->słabość['Wodny'] = true;
        $this->słabość['Trujący'] = true;
    }
}