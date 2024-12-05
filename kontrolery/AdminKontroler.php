<?php

class AdminKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Úvodní strana',
            'klicova_slova' => '',
            'popis' => ''
        );
    }
}