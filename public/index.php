<?php

require_once '../bootstrap/bootstrap.php';

/** @var \League\Route\Router $router */
$router = require_once '../routes/routes.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);
try {
    $response = $router->dispatch($request);
} catch (\League\Route\Http\Exception\NotFoundException $exception) {
    http_response_code(404);
    die;
}
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);