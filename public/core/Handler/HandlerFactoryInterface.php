<?php

declare(strict_types=1);

namespace Core\Handler;

interface HandlerFactoryInterface
{
    public function createHandler(string $handlerName): HandlerInterface;
}
