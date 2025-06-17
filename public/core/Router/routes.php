<?php

declare(strict_types=1);

use Core\Router\Route;

return [
    new Route('/analyze', 'analyze', ['GET', 'POST']),
    new Route('/parse', 'parse', ['GET', 'POST']),
    new Route('/generate', 'generate', ['GET', 'POST']),
];
