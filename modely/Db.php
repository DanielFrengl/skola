<?php

class Db
{
    /**
     * @var PDO Databázové spojení
     */
    private static ?PDO $spojeni = null;

    /**
     * @var array Výchozí nastavení ovladače
     */
    private static array $nastaveni = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /**
     * Připojí se k databázi pomocí daných údajů
     * @param string $host Hostitel databáze
     * @param string $uzivatel Přihlašovací jméno
     * @param string $heslo Přihlašovací heslo
     * @param string $databaze Název databáze
     * @return void
     * @throws PDOException Pokud připojení selže
     */
    public static function pripoj(string $host, string $uzivatel, string $heslo, string $databaze): void
    {
        if (self::$spojeni === null) {
            try {
                self::$spojeni = new PDO(
                    "mysql:host=$host;dbname=$databaze",
                    $uzivatel,
                    $heslo,
                    self::$nastaveni
                );
            } catch (PDOException $e) {
                // Log error or handle it appropriately
                throw new PDOException("Database connection failed: " . $e->getMessage());
            }
        }
    }

    /**
     * Spustí dotaz a vrátí z něj první řádek
     * @param string $dotaz SQL dotaz s parametry nahrazenými otazníky
     * @param array $parametry Parametry pro doplnění do připraveného SQL dotazu
     * @return array|false Asociativní pole s informacemi z prvního řádku výsledku, nebo false
     */
    public static function dotazJeden(string $dotaz, array $parametry = []): array|false
    {
        $stmt = self::$spojeni->prepare($dotaz);
        $stmt->execute($parametry);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Spustí dotaz a vrátí všechny jeho řádky
     * @param string $dotaz SQL dotaz s parametry nahrazenými otazníky
     * @param array $parametry Parametry pro doplnění do připraveného SQL dotazu
     * @return array Pole asociativních polí s informacemi o všech řádcích výsledku
     */
    public static function dotazVsechny(string $dotaz, array $parametry = []): array
    {
        $stmt = self::$spojeni->prepare($dotaz);
        $stmt->execute($parametry);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Spustí dotaz a vrátí z něj první sloupec prvního řádku
     * @param string $dotaz SQL dotaz s parametry nahrazenými otazníky
     * @param array $parametry Parametry pro doplnění do připraveného SQL dotazu
     * @return string|null Hodnota v prvním sloupci prvního řádku výsledku nebo null
     */
    public static function dotazSamotny(string $dotaz, array $parametry = []): ?string
    {
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek ? $vysledek[0] : null;
    }

    /**
     * Spustí dotaz a vrátí počet ovlivněných řádků
     * @param string $dotaz SQL dotaz s parametry nahrazenými otazníky
     * @param array $parametry Parametry pro doplnění do připraveného SQL dotazu
     * @return int Počet ovlivněných řádků
     */
    public static function dotaz(string $dotaz, array $parametry = []): int
    {
        $stmt = self::$spojeni->prepare($dotaz);
        $stmt->execute($parametry);
        return $stmt->rowCount();
    }
}
