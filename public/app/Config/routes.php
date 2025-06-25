<?php

declare(strict_types=1);

use App\Router\Route;
use App\Router\RouteAttribute;

$controllersDir = __DIR__ . '/../Controllers';
$routes = [];

foreach (scandir($controllersDir) as $file) {
    if (str_ends_with($file, 'Controller.php')) {
        $class = 'App\\Controllers\\' . basename($file, '.php');
        if (! class_exists($class)) {
            require_once $controllersDir . '/' . $file;
        }
        if (! class_exists($class)) {
            continue;
        }

        /** @var class-string $class */
        try {
            $refClass = new ReflectionClass($class);
            foreach ($refClass->getMethods() as $method) {
                $attributes = $method->getAttributes(RouteAttribute::class);
                foreach ($attributes as $attr) {
                    $instance = $attr->newInstance();
                    $routes[] = new Route(
                        $instance->method,
                        $instance->path,
                        [$class, $method->getName()]
                    );
                }
            }
        } catch (ReflectionException $e) {
            header('HTTP/1.0 404 Not Found');
            require __DIR__ . '/../../app/Views/errors/404.php';
        }
    }
}

return $routes;
