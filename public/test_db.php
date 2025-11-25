<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Database;

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
        $pdo = Database::getPdo();
        echo "✅ Connexion réussie à la base de données !<br>";

        // Test simple : lister les joueurs
        $stmt = $pdo->query("SELECT * FROM players");
        $players = $stmt->fetchAll();

        echo "<pre>";
        print_r($players);
        echo "</pre>";
} catch (PDOException $e) {
        echo "❌ Erreur de connexion : " . $e->getMessage();
}
