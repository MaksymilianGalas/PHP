<?php
class samochod
{
    private $id;
    private $marka;
    private $model;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMarka()
    {
        return $this->marka;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getRok()
    {
        return $this->rok;
    }

    /**
     * @return mixed
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * @return mixed
     */
    public function getPojemnosc()
    {
        return $this->pojemnosc;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }
    private $rok;
    private $cena;
    private $pojemnosc;
    private $link;

    /**
     * @param $id
     * @param $marka
     * @param $model
     * @param $rok
     * @param $cena
     * @param $pojemnosc
     * @param $link
     */
    public function __construct($id, $marka, $model, $rok, $cena, $pojemnosc, $link)
    {
        $this->id = $id;
        $this->marka = $marka;
        $this->model = $model;
        $this->rok = $rok;
        $this->cena = $cena;
        $this->pojemnosc = $pojemnosc;
        $this->link = $link;
    }
}