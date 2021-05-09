<?php

require_once '../bootstrap/bootstrap.php';

/** @var \League\Route\Router $router */
$router = require_once '../routes/routes.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);
$response = $router->dispatch($request);
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);