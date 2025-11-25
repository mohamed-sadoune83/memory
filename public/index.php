<?php
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Core\Router;
use app\Controllers\GameController;
use app\Controllers\HomeController;
use app\Controllers\PlayerController;
use app\Controllers\LeaderboardController;
use app\Controllers\AuthController;

$router = new Router();

// Home
$router->get('/', HomeController::class . '@index');

// Game
$router->get('/game/play', GameController::class . '@play');
$router->post('/game/play', GameController::class . '@play');

// Route pour sauvegarder la partie
$router->post('/game/save', GameController::class . '@save');

// Player Profile
$router->get('/player/profile', PlayerController::class . '@profile');

// Leaderboard
$router->get('/leaderboard', LeaderboardController::class . '@top10');

// Login et Logout
$router->get('/login', AuthController::class . '@login');
$router->post('/login', AuthController::class . '@login');
$router->get('/logout', AuthController::class . '@logout');

// DISPATCH
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
