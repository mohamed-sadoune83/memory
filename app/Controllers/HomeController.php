<?php
namespace app\Controllers;

use Core\BaseController;
use app\Models\Player;
use app\Models\Card;
use app\Models\Theme;

class HomeController extends BaseController
{
    public function index(): void
    {
        $playerModel = new Player();
        $players = $playerModel->getTop3();

        $themeModel = new Theme();
        $themes = $themeModel->all();

        $DEFAULT_THEME = 7;

        $selectedTheme = isset($_GET['theme']) && $_GET['theme'] !== ''
            ? (int) $_GET['theme']
            : $DEFAULT_THEME;

        $cardModel = new Card();
        $cards = $cardModel->getByTheme($selectedTheme);

        $this->render('home/index', [
            'title' => 'Memory Game',
            'players' => $players,
            'cards' => $cards,
            'themes' => $themes,
            'selectedTheme' => $selectedTheme
        ]);
    }
}
