<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Router;
use Core\Handler\AnalyzeHandler;
use Core\Handler\ParseHandler;

// Initialize application
$app = new Application();

// Create handlers
$analyzeHandler = new AnalyzeHandler($app->getUserRepository());
$parseHandler = new ParseHandler($app->getUserRepository(), $app->getCsvParser());

// Create router
$router = new Router($analyzeHandler, $parseHandler);

// Get the request path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router->route($path);
