<?php
namespace Core;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, string $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            if ($route === $path) {
                [$class, $method] = explode('@', $action);

                $controller = new $class();

                $controller->$method();
                return;
            }
        }

        http_response_code(404);
        echo "404 - Page non trouvée";
    }
}
