<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (!self::$pdo) {
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ":" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                exit('Erreur de connexion BDD');
            }
        }

        return self::$pdo;
    }
}
