<?php
namespace app\Controllers;

use Core\BaseController;
use app\Models\Card;
use app\Models\Game;
use app\Models\Theme;

class GameController extends BaseController
{
        public function play(): void
        {

                if (session_status() === PHP_SESSION_NONE)
                        session_start();

                $playerId = $_SESSION['user']['id'] ?? null;
                if (!$playerId) {
                        header("Location: /login?redirect=/game/play");
                        exit;
                }

                $themeId = $_GET["theme"] ?? 7;
                $pairs = $_GET["pairs"] ?? 6;

                $allowed = [3, 6, 12];
                if (!in_array($pairs, $allowed)) {
                        $pairs = 6;
                }

                $cardModel = new Card();
                $cards = $cardModel->getRandomPairs($pairs, $themeId);

                $themeModel = new Theme();
                $themes = $themeModel->all();

                $selectedThemeName = '';
                foreach ($themes as $theme) {
                        if ($theme['id'] == $themeId) {
                                $selectedThemeName = $theme['name'];
                                break;
                        }
                }

                $this->render("game/play", [
                        "cards" => $cards,
                        "pairs" => $pairs,
                        "themeId" => $themeId,
                        "themes" => $themes,
                        "playerId" => $playerId,
                        "selectedThemeName" => $selectedThemeName,
                ]);
        }

        public function save(): void
        {
                if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                        http_response_code(405);
                        exit;
                }

                $playerId = $_POST["player_id"] ?? null;
                if (!$playerId) {
                        http_response_code(400);
                        echo json_encode(["error" => "Player ID manquant"]);
                        exit;
                }

                $pairs = (int) ($_POST["pairs"] ?? 0);
                $moves = (int) ($_POST["moves"] ?? 0);
                $time = (int) ($_POST["time_seconds"] ?? 0);

                $gameModel = new Game();
                $score = $gameModel->calculateScore($pairs, $moves, $time);

                $gameId = $gameModel->createGame([
                        "player_id" => $playerId,
                        "pairs" => $pairs,
                        "moves" => $moves,
                        "time_seconds" => $time,
                        "score" => $score
                ]);

                echo json_encode([
                        "success" => true,
                        "score" => $score,
                        "game_id" => $gameId
                ]);
                exit;
        }
}
