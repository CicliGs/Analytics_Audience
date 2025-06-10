<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Router;
use Core\Handler\AnalyzeHandler;
use Core\Handler\ParseHandler;
use App\CsvImporter;

$app = new Application();

$analyzeHandler = new AnalyzeHandler($app->getUserRepository());
$csvImporter = new CsvImporter($app->getConnection());
$parseHandler = new ParseHandler($app->getUserRepository(), $app->getCsvParser(), $csvImporter);

$router = new Router($analyzeHandler, $parseHandler);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->route($path);
