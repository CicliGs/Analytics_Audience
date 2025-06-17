<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\CsvImporter;
use Core\Application;
use Core\Handler\HandlerFactory;
use Core\Router\Router;

$app = new Application();

$csvImporter = new CsvImporter($app->getConnection());

$handlerFactory = new HandlerFactory(
    $app->getUserRepository(),
    $app->getCsvParser(),
    $csvImporter
);

$router = new Router($handlerFactory);

$routes = require __DIR__ . '/core/Router/routes.php';

foreach ($routes as $route) {
    $router->addRoute($route);
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($path, $method);
