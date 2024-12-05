<?php

/*
 *  _____ _______         _                      _
 * |_   _|__   __|       | |                    | |
 *   | |    | |_ __   ___| |___      _____  _ __| | __  ___ ____
 *   | |    | | '_ \ / _ \ __\ \ /\ / / _ \| '__| |/ / / __|_  /
 *  _| |_   | | | | |  __/ |_ \ V  V / (_) | |  |   < | (__ / /
 * |_____|  |_|_| |_|\___|\__| \_/\_/ \___/|_|  |_|\_(_)___/___|
 *                   ___
 *                  |  _|___ ___ ___
 *                  |  _|  _| -_| -_|  LICENCE
 *                  |_| |_| |___|___|
 *
 *    REKVALIFIKAČNÍ KURZY  <>  PROGRAMOVÁNÍ  <>  IT KARIÉRA
 *
 * Tento zdrojový kód pochází z IT kurzů na WWW.ITNETWORK.CZ
 *
 * Můžete ho upravovat a používat jak chcete, musíte však zmínit
 * odkaz na http://www.itnetwork.cz
 */

/**
 * Výchozí kontroler pro ITnetworkMVC
 */


abstract class Kontroler
{

	/**
	 * @var array Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
	 */
	protected array $data = array();
	/**
	 * @var string Název šablony bez přípony
	 */
	protected string $pohled = "";
	/**
	 * @var array|string[] Hlavička HTML stránky
	 */
	protected array $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');

	/**
	 * Vyrenderuje pohled
	 * @return void
	 */
	public function vypisPohled(): void
	{
		if ($this->pohled) {
			extract($this->data);
			require("pohledy/" . $this->pohled . ".phtml");
		}
	}

	/**
	 * Přesměruje na dané URL
	 * @param string $url URL adresa, na kterou přesměrovat
	 * @return never
	 */
	public function presmeruj(string $url): never
	{
		header("Location: /$url");
		header("Connection: close");
		exit;
	}

	/**
	 * Hlavní metoda controlleru
	 * @param array $parametry Pole parametrů pro využití kontrolerem
	 * @return void
	 */
	abstract function zpracuj(array $parametry): void;

    private function osetri(mixed $x = null): mixed
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x)) {
            foreach($x as $k => $v) {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        } else
            return $x;
    }

}