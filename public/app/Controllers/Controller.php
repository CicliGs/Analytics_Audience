<?php

declare(strict_types=1);

namespace App\Controllers;

use JetBrains\PhpStorm\NoReturn;

/**
 *
 */
abstract class Controller
{
    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . "/../Views/$view.php";
    }

    #[NoReturn]
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
