<?php

declare(strict_types=1);

namespace Core\Router;

use Core\Handler\HandlerFactoryInterface;

class Router
{
    /**
     * @var array<string, RouteInterface>
     */
    private array $routes = [];

    public function __construct(
        private readonly HandlerFactoryInterface $handlerFactory
    ) {
    }

    public function addRoute(RouteInterface $route): void
    {
        $this->routes[$route->getPath()] = $route;
    }

    public function route(string $path, string $method = 'GET'): void
    {
        if (! isset($this->routes[$path])) {
            $this->handleNotFound();

            return;
        }

        $route = $this->routes[$path];
        if (! in_array($method, $route->getMethods(), true)) {
            $this->handleMethodNotAllowed();

            return;
        }

        $handler = $this->handlerFactory->createHandler($route->getHandler());
        $handler->handle();
    }

    private function handleNotFound(): void
    {
        header('HTTP/1.0 404 Not Found');
        require __DIR__ . '/../../app/templates/404.php';
    }

    private function handleMethodNotAllowed(): void
    {
        header('HTTP/1.0 405 Method Not Allowed');
        require __DIR__ . '/../../app/templates/405.php';
    }
}
