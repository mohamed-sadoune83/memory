<?php
namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
    public function index(): void
    {
        $this->render('home/index', [
            'title' => 'Bienvenue sur le mini-MVC'
        ]);
    }

    public function about(): void
    {
        $this->render('home/about', [
            'title' => 'À propos de nous'
        ]);
    }
}
