<?php

use Bramus\Router\Router;

return function (Router $router) {
    // set namespace for controllers
    $router->setNamespace('App\Controllers');

    // root endpoint - health check
    $router->get('/', 'OrderController@index');

    // order endpoints
    $router->post('/orders', 'OrderController@store');
    $router->patch('/orders/([a-f0-9\-]+)', 'OrderController@update');

    // seed endpoint for development/testing
    $router->post('/orders/seed', 'OrderController@seed');
};
