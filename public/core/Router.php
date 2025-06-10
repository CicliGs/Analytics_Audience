<?php

declare(strict_types=1);

namespace Core;

use Core\Handler\HandlerInterface;

class Router
{
    private array $routes = [];

    public function __construct(
        private readonly HandlerInterface $analyzeHandler,
        private readonly HandlerInterface $parseHandler
    ) {
        $this->routes = [
            '/analyze' => $this->analyzeHandler,
            '/parse' => $this->parseHandler,
        ];
    }

    public function route(string $path): void
    {
        if (isset($this->routes[$path])) {
            $this->routes[$path]->handle();

            return;
        }

        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../app/templates/404.php';
    }
}
