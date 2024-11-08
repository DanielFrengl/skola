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
 * Pomocná třída, poskytující metody pro odeslání emailu
 */
class OdesilacEmailu
{

	/**
	 * Odešle email jako HTML, lze tedy používat základní HTML tagy a nové
	 * řádky je třeba psát jako <br /> nebo používat odstavce. Kódování je
	 * odladěno pro UTF-8.
	 * @param string $komu E-mailová adresa příjemce
	 * @param string $predmet Předmět e-mailu
	 * @param string $zprava Obsah e-mailu jako HTML řetězec
	 * @param string $od E-mailová adresa odesílatele
	 * @return bool TRUE, pokud se odeslání e-mailu podařilo, FALSE, pokud ne
	 */
	public function odesli(string $komu, string $predmet, string $zprava, string $od): bool
	{
		$hlavicka = "From: " . $od;
		$hlavicka .= "\nMIME-Version: 1.0\n";
		$hlavicka .= "Content-Type: text/html; charset=\"utf-8\"\n";
		return mb_send_mail($komu, $predmet, $zprava, $hlavicka);
	}

}