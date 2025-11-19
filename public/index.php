<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

use Core\Router;

$router = new Router();

// Routes GET
$router->get('/', 'App\\Controllers\\HomeController@index');
$router->get('/about', 'App\\Controllers\\HomeController@about');
$router->get('/articles', 'App\\Controllers\\ArticleController@index');

// Exécution du routeur :
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
