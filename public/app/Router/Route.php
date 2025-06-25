<?php

declare(strict_types=1);

namespace App\Router;

class Route
{
    private string $normalizedPath;
    private string $normalizedMethod;

    /**
     * @param array{0: class-string, 1: string}|string $action
     */
    public function __construct(
        string $method,
        string $path,
        private readonly array|string $action
    ) {
        $this->normalizedPath = '/' . trim($path, '/');
        $this->normalizedMethod = strtolower($method);
    }

    public function getMethod(): string
    {
        return $this->normalizedMethod;
    }

    public function getPath(): string
    {
        return $this->normalizedPath;
    }

    /**
     * @return array{class-string, string}|string
     */
    public function getAction(): array|string
    {
        return $this->action;
    }
}
