<?php

declare(strict_types=1);

namespace Core\Router;

readonly class Route implements RouteInterface
{
    /**
     * @param string[] $methods
     */
    public function __construct(
        private string $path,
        private string $handler,
        private array  $methods = ['GET']
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    /**
     * @return array|string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
