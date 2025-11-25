<?php
namespace app\Controllers;

use Core\BaseController;
use app\Models\Game;

class LeaderboardController extends BaseController
{
        public function top10(): void
        {
                $gameModel = new Game();

                $topGames = $gameModel->getTop10WithPlayer();

                $this->render('leaderboard/top10', [
                        'title' => 'Classement',
                        'players' => $topGames
                ]);
        }
}
