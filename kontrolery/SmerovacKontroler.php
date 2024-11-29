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
 * Router je speciální typ controlleru, který podle URL adresy zavolá
 * správný controller a jím vytvořený pohled vloží do šablony stránky
 */

require_once __DIR__ . '/Kontroler.php';

class SmerovacKontroler extends Kontroler
{
    /**
     * @var Kontroler Instance kontrolleru
     */
    protected Kontroler $kontroler;

    /**
     * Metoda převede pomlčkovou variantu controlleru na název třídy
     * @param string $text Řetězec v pomlckove-notaci
     * @return string Řetězec převedený do velbloudiNotace
     */
    private function pomlckyDoVelbloudiNotace(string $text): string
    {
        $veta = str_replace('-', ' ', $text);
        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);
        return $veta;
    }

    /**
     * Naparsuje URL adresu podle lomítek a vrátí pole parametrů
     * @param string $url URL adresa k naparsování
     * @return array Pole URL parametrů
     */
    private function parsujURL(string $url): array
    {
        // Naparsuje jednotlivé části URL adresy do asociativního pole
        $naparsovanaURL = parse_url($url);
        // Odstranění počátečního lomítka
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        // Odstranění bílých znaků kolem adresy
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        // Rozbití řetězce podle lomítek
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }

    /**
     * Naparsování URL adresy a vytvoření příslušného controlleru
     * @param array $parametry
     * @return void
     */
    public function zpracuj(array $parametry): void
    {
        // Parse the URL
        $naparsovanaURL = $this->parsujURL($parametry[0]);

        // Redirect to the homepage if the URL is empty
        if (empty($naparsovanaURL[0])) {
            $this->presmeruj('uvod');
        }

        // Check the first part of the URL for specific routes
        switch ($naparsovanaURL[0]) {
            case 'event':
                $kontroler = new EventCalendarKontroler();

                // If the URL has a second parameter and it's 'getEvents'
                if (isset($naparsovanaURL[1]) && $naparsovanaURL[1] === 'getEvents') {
                    $kontroler->getEvents();
                    exit; // Stop further execution after outputting JSON
                }

                // Otherwise, process the URL normally
                $kontroler->zpracuj($naparsovanaURL);
                return;

            // Add more routes as needed
            // case 'other-route':
            //     $kontroler = new OtherRouteKontroler();
            //     $kontroler->zpracuj($naparsovanaURL);
            //     return;

            default:
                // If no route matches, process as a standard controller
                $tridaKontroleru = $this->pomlckyDoVelbloudiNotace(array_shift($naparsovanaURL)) . 'Kontroler';

                // Check if the controller file exists
                if (file_exists('kontrolery/' . $tridaKontroleru . '.php')) {
                    $this->kontroler = new $tridaKontroleru;
                } else {
                    // Redirect to an error page if the controller doesn't exist
                    $this->presmeruj('chyba');
                }

                // Call the controller
                $this->kontroler->zpracuj($naparsovanaURL);

                // Set template variables
                $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
                $this->data['popis'] = $this->kontroler->hlavicka['popis'];
                $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];

                // Set the main template
                $this->pohled = 'sablona';
                break;
        }
    }
}