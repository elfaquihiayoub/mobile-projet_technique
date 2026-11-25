<?php

class Database
{
    // --- Identifiants de connexion MySQL ---
    private const HOST   = 'localhost';
    private const DBNAME = 'Annuaire_de_podcasts';
    private const USER   = 'root';
    private const PASS   = 'ayoub.fh2k52k5';

    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=utf8";

            self::$pdo = new PDO($dsn, self::USER, self::PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$pdo;
    }
}