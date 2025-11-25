<?php
namespace app\Models;
use Core\Database;
use Core\BaseModel;
use PDO;

class Game extends BaseModel
{
        public function createGame(array $data): int
        {
                $sql = "INSERT INTO games (player_id, pairs, moves, time_seconds, score, created_at)
                VALUES (:player_id, :pairs, :moves, :time_seconds, :score, NOW())";

                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                        "player_id" => $data["player_id"],
                        "pairs" => $data["pairs"],
                        "moves" => $data["moves"],
                        "time_seconds" => $data["time_seconds"],
                        "score" => $data["score"]
                ]);
                return Database::getPdo()->lastInsertId();
        }

        public function getGame(int $id): ?array
        {
                $stmt = Database::getPdo()->prepare("SELECT * FROM games WHERE id = ?");
                $stmt->execute([$id]);

                $game = $stmt->fetch(PDO::FETCH_ASSOC);

                return $game ?: null;
        }

        public function getGamesByPlayer(int $playerId): array
        {
                $stmt = Database::getPdo()->prepare(
                        "SELECT * FROM games WHERE player_id = ? ORDER BY created_at DESC"
                );
                $stmt->execute([$playerId]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function calculateScore(int $pairs, int $moves, int $time): int
        {
                // Score de base
                $base = max(0, ($pairs * 200) - ($moves * 3) - ($time * 2));

                // Bonus selon difficulté
                $bonusMultiplier = 1.0;

                switch ($pairs) {
                        case 3:  // Facile
                                $bonusMultiplier = 1.0;
                                break;

                        case 6:  // Normal
                                $bonusMultiplier = 1.3;
                                break;

                        case 12: // Difficile
                                $bonusMultiplier = 1.6;
                                break;
                }

                return (int) round($base * $bonusMultiplier);
        }


        public function getTop10WithPlayer(): array
        {
                $sql = "SELECT g.score, g.moves, g.time_seconds, g.pairs, p.username, g.created_at
                FROM games g
                JOIN players p ON g.player_id = p.id
                ORDER BY g.score DESC
                LIMIT 10";

                $stmt = $this->db->query($sql);
                return $stmt->fetchAll();
        }

}



