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
 * Kontroler pro zpracování stránky s kontaktním formulářem
 */
class KontaktKontroler extends Kontroler
{
	public function zpracuj(array $parametry): void
	{
		$this->hlavicka = array(
			'titulek' => 'Kontaktní formulář',
			'klicova_slova' => 'kontakt, email, formulář',
			'popis' => 'Kontaktní formulář našeho webu.'
		);
		
		if (isset($_POST["email"])) {
			if ($_POST['rok'] == date("Y")) {
				$odesilacEmailu = new OdesilacEmailu();
				$odesilacEmailu->odesli("admin@adresa.cz", "Email z webu", $_POST['zprava'], $_POST['email']);
			}
		}
		
		$this->pohled = 'kontakt';
    }
}