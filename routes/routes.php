<?php

use League\Route\Router;

$router = new Router();

$router->map('GET', '/', [Controllers\TaskController::class, 'index']);
$router->map('POST', '/', [Controllers\TaskController::class, 'store']);
$router->map('GET', '/create', [Controllers\TaskController::class, 'create']);
$router->map('GET', '/login', [Controllers\LoginController::class, 'showLoginPage']);
$router->map('POST', '/login', [Controllers\LoginController::class, 'login']);
$router->map('POST', '/logout', [Controllers\LoginController::class, 'logout']);

$router->group('/tasks', function (League\Route\RouteGroup $route) {
    $route->map('GET', '/{id}/edit', [Controllers\TaskController::class, 'edit']);
    $route->map('POST', '/{id}', [Controllers\TaskController::class, 'update']);
    $route->map('POST', '/{id}/done', [Controllers\TaskController::class, 'done']);
});

return $router;