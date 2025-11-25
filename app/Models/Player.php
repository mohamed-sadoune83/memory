<?php
namespace app\Models;

use Core\Database;
use PDO;

class Player
{
        public static function all(): array
        {
                $stmt = Database::getPdo()->query("SELECT * FROM players ORDER BY username ASC");
                return $stmt->fetchAll();
        }

        public function verifyPassword(int $id, string $password): bool
        {
                $stmt = Database::getPdo()->prepare("SELECT password FROM players WHERE id = ?");
                $stmt->execute([$id]);
                $hash = $stmt->fetchColumn();
                return password_verify($password, $hash);
        }

        public function find(int $id): ?array
        {
                $stmt = Database::getPdo()->prepare("SELECT * FROM players WHERE id = ?");
                $stmt->execute([$id]);
                return $stmt->fetch() ?: null;
        }

        public function findByUsername(string $username): ?array
        {
                $stmt = Database::getPdo()->prepare("SELECT * FROM players WHERE username = ?");
                $stmt->execute([$username]);
                return $stmt->fetch() ?: null;
        }

        public function getBestScores(int $playerId): array
        {
                $sql = "SELECT * FROM games WHERE player_id = ? ORDER BY score DESC LIMIT 10";
                $stmt = Database::getPdo()->prepare($sql);
                $stmt->execute([$playerId]);
                return $stmt->fetchAll();
        }

        public function getTopScores(int $playerId, int $limit = 3): array
        {
                $limit = (int) $limit; // s'assurer que c'est un entier
                $stmt = Database::getPdo()->prepare(
                        "SELECT score, created_at FROM games WHERE player_id = ? ORDER BY score DESC LIMIT $limit"
                );
                $stmt->execute([$playerId]);
                return $stmt->fetchAll();
        }

        public function getTop10(): array
        {
                $sql = "
        SELECT g.score, g.pairs, g.created_at, p.username
        FROM games g
        JOIN players p ON g.player_id = p.id
        ORDER BY g.score DESC
        LIMIT 10
        ";
                $stmt = Database::getPdo()->query($sql);
                return $stmt->fetchAll();
        }

        public function getTop3(): array
        {
                $sql = "
        SELECT p.username, g.score, g.created_at
        FROM games g
        JOIN players p ON p.id = g.player_id
        ORDER BY g.score DESC
        LIMIT 3
        ";
                return Database::getPdo()->query($sql)->fetchAll();
        }
}
