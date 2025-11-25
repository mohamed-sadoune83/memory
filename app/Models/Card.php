<?php
namespace app\Models;

use Core\Database;

class Card
{
        public int $id;
        public string $name;
        public string $image_path;
        public int $theme_id;

        public function __construct(int $id = 0, string $name = '', string $image_path = '', int $theme_id = 0)
        {
                $this->id = $id;
                $this->name = $name;
                $this->image_path = $image_path;
                $this->theme_id = $theme_id;
        }

        public function all(): array
        {
                $stmt = Database::getPdo()->query("SELECT * FROM cards");
                return $stmt->fetchAll();
        }

        public function getByTheme(int $themeId): array
        {
                $stmt = Database::getPdo()->prepare("SELECT * FROM cards WHERE theme_id = ?");
                $stmt->execute([$themeId]);
                return $stmt->fetchAll();
        }

        public function getRandomPairs(int $count, int $themeId): array
        {
                $cards = $this->getByTheme($themeId);

                shuffle($cards);

                // On prend X cartes et on duplique pour faire les paires
                $selected = array_slice($cards, 0, $count);
                $pairs = array_merge($selected, $selected);

                shuffle($pairs);

                return $pairs;
        }
}
