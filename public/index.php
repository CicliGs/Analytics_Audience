<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\CsvImporter;
use Core\Application;
use Core\Handler\AnalyzeHandler;
use Core\Handler\GenerateHandler;
use Core\Handler\ParseHandler;
use Core\Router;

$app = new Application();

$analyzeHandler = new AnalyzeHandler($app->getUserRepository());
$csvImporter = new CsvImporter($app->getConnection());
$parseHandler = new ParseHandler($app->getCsvParser(), $csvImporter);
$generateHandler = new GenerateHandler();

$router = new Router($analyzeHandler, $parseHandler, $generateHandler);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->route($path);
