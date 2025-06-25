<?php

declare(strict_types=1);

namespace App\Router;

use RuntimeException;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    /**
     * @param array<class-string, object> $controllers
     */
    public function __construct(
        private readonly array $controllers
    ) {
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function route(string $path, string $method): void
    {
        $method = strtolower($method);
        error_log("Router: Processing request for path '$path' with method '$method'");
        error_log("Router: Number of registered routes: " . count($this->routes));

        foreach ($this->routes as $route) {
            $routePath = $route->getPath();
            $routeMethod = strtolower($route->getMethod());

            error_log("Router: Checking route - Method: '$routeMethod', Path: '$routePath'");
            error_log("Router: Comparing paths - Request: '$path', Route: '$routePath'");
            error_log("Router: Comparing methods - Request: '$method', Route: '$routeMethod'");

            if ($routePath === $path && $routeMethod === $method) {
                $action = $route->getAction();
                error_log("Router: Route matched! Action: " . (is_array($action) ? implode('::', $action) : $action));

                if (is_array($action)) {
                    [$controllerClass, $controllerMethod] = $action;
                    if (! isset($this->controllers[$controllerClass])) {
                        throw new RuntimeException("Controller not found: $controllerClass");
                    }
                    $controller = $this->controllers[$controllerClass];
                    error_log("Router: Using controller instance: " . get_class($controller));
                    $controller->$controllerMethod();
                }

                return;
            }
        }

        error_log("Router: No matching route found for path '$path' and method '$method'");
        header('HTTP/1.0 404 Not Found');
        require __DIR__ . '/../../app/Views/errors/404.php';
    }
}
