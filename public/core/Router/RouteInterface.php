<?php

declare(strict_types=1);

namespace Core\Router;

interface RouteInterface
{
    public function getPath(): string;

    public function getHandler(): string;

    /**
     * @return array|string[]
     */
    public function getMethods(): array;
}
