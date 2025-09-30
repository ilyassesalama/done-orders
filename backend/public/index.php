<?php
require __DIR__ . '/../vendor/autoload.php';

use Bramus\Router\Router;

// Load configuration
$config = require __DIR__ . '/../config.php';

// set CORS headers (this is too strict imo, but i added this to demonstrate how cors work)
header("Access-Control-Allow-Origin: " . $config['cors']['allowed_origin']);
header("Access-Control-Allow-Methods: " . $config['cors']['allowed_methods']);
header("Access-Control-Allow-Headers: " . $config['cors']['allowed_headers']);

$router = new Router();

// handle preflight OPTIONS requests for CORS
$router->options('/.*', function () {
    http_response_code(200);
    exit();
});

// load API routes
$routes = require __DIR__ . '/../routes/api.php';
$routes($router);

// run the router
$router->run();
