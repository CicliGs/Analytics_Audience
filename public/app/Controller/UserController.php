<?php

declare(strict_types=1);

namespace App\Controller;

use Core\Application;

class UserController
{
    private Application $app;

    public function __construct()
    {
        $this->app = new Application();
    }

    public function index(): void
    {
        $results = $this->app->handleRequest($_POST);
        require_once __DIR__ . '/../templates/results.php';

    }
}
