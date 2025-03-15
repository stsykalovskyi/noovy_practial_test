<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Controllers\DestinationController;

// Create a PDO instance and connect to the SQLite database
$pdo = new PDO("sqlite:" . __DIR__ . '/../database/destinations.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Pass PDO to the controller
$app->get('/destinations', function ($request, $response, $args) use ($pdo) {
    $controller = new DestinationController($pdo);
    return $controller->getDestinations($request, $response);
});

$app->run();
