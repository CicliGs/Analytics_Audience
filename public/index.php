<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Application;
use App\Controllers\AnalyzeController;
use App\Controllers\GenerateController;
use App\Controllers\ParseController;
use App\Models\UserRepository;
use App\Router\Router;
use App\Services\CsvImporter;
use App\Services\CsvGeneratorService;
use App\Services\FileService;

$app = new Application();

$userRepository = new UserRepository($app->getConnection(), $app->getFilterPool());
$csvImporter = new CsvImporter($app->getConnection());
$csvGeneratorService = new CsvGeneratorService();
$fileService = new FileService();

$analyzeController = new AnalyzeController($userRepository);
$parseController = new ParseController($csvImporter);
$generateController = new GenerateController($csvGeneratorService, $fileService);

$controllers = [
    AnalyzeController::class => $analyzeController,
    ParseController::class => $parseController,
    GenerateController::class => $generateController,
];

$router = new Router($controllers);

$routes = require __DIR__ . '/app/Config/routes.php';

foreach ($routes as $route) {
    $router->addRoute($route);
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = '/' . trim($path, '/');
$method = strtolower($_SERVER['REQUEST_METHOD']);

error_log("Request URI: " . $_SERVER['REQUEST_URI']);
error_log("Parsed path: " . $path);
error_log("Request method: " . $method);
error_log("Registered routes:");
foreach ($routes as $route) {
    error_log("- {$route->getMethod()} {$route->getPath()}");
}

$router->route($path, $method);
