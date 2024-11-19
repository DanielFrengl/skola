<?php

require_once __DIR__ . '/Kontroler.php';
class UvodKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Úvodní strana',
            'klicova_slova' => '',
            'popis' => ''
        );


        $this->pohled = 'uvod';
    }
}