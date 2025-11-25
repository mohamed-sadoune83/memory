<?php
namespace Core;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    // Enregistre une route GET
    public function get(string $path, string $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    // Enregistre une route POST
    public function post(string $path, string $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    // Dispatche la route
    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            if ($route === $path) {
                [$class, $methodName] = explode('@', $action);

                // Instanciation du contrôleur
                $controller = new $class();

                // Appel de la méthode
                $controller->$methodName();
                return;
            }
        }

        // 404 si route non trouvée
        http_response_code(404);
        echo "404 - Page non trouvée";
    }
}
