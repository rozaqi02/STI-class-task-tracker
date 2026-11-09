<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Handle semua preflight OPTIONS
$routes->options('api/(:any)', static function () {
    header('Access-Control-Allow-Origin: http://localhost:5173');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Allow-Credentials: true');
    http_response_code(200);
    exit;
});

$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->post('auth/register', 'Api\AuthController::register');
    $routes->post('auth/login', 'Api\AuthController::login');

    $routes->get('tasks', 'Api\TaskController::index');
    $routes->post('tasks', 'Api\TaskController::create');
    $routes->put('tasks/(:num)', 'Api\TaskController::update/$1');
    $routes->delete('tasks/(:num)', 'Api\TaskController::delete/$1');
    $routes->post('tasks/(:num)/complete', 'Api\TaskController::complete/$1');
});