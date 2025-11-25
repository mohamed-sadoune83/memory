<?php
namespace app\Controllers;

use Core\BaseController;
use app\Models\Player;

class PlayerController extends BaseController
{
        public function profile(): void
        {
                $id = $_GET['player'] ?? 1;

                $playerModel = new Player();
                $playerData = $playerModel->find((int) $id);

                $topScores = $playerModel->getTopScores((int) $id, 3);

                $this->render("player/profile", [
                        "title" => "Profil joueur",
                        "player" => $playerData,
                        "topScores" => $topScores
                ]);
        }
}
