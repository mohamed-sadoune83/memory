<?php
namespace app\Controllers;

use Core\BaseController;
use app\Models\Player;

class AuthController extends BaseController
{
        public function login(): void
        {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $username = $_POST['username'] ?? '';
                        $password = $_POST['password'] ?? '';

                        $playerModel = new Player();
                        $user = $playerModel->findByUsername($username);

                        if ($user && password_verify($password, $user['password'])) {
                                session_start();
                                $_SESSION['user'] = [
                                        'id' => $user['id'],
                                        'username' => $user['username']
                                ];

                                header('Location: /game/play'); 
                                exit;
                        }


                        // Erreur
                        $this->render('home/login', [
                                'title' => 'Connexion',
                                'error' => 'Nom d’utilisateur ou mot de passe incorrect.'
                        ]);
                        return;
                }

                $this->render('home/login', ['title' => 'Connexion']);
        }

        public function logout(): void
        {
                session_start();
                session_unset();
                session_destroy();
                header('Location: /login');
                exit;
        }
}
