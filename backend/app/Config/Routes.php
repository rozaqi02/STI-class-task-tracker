<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
    $routes->group('api', function ($routes) {
    $routes->post('auth/register', 'Api\AuthController::register');
    $routes->post('auth/login', 'Api\AuthController::login');

    // Task routes
    $routes->get('tasks', 'Api\TaskController::index');
    $routes->post('tasks', 'Api\TaskController::create');
    $routes->put('tasks/(:num)', 'Api\TaskController::update/$1');
    $routes->delete('tasks/(:num)', 'Api\TaskController::delete/$1');
    $routes->post('tasks/(:num)/complete', 'Api\TaskController::complete/$1');
});