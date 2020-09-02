<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('test', ['as' => 'test', 'uses' => 'ExampleController@test']);
