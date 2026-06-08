<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('api', static function ($routes) {
    $routes->group('user', ['namespace' => 'App\Controllers\Api\User'], static function ($routes) {
        $routes->post('login', 'Login::index');
        $routes->post('register', 'Register::index');
    });
});

$routes->group('user', ['namespace' => 'App\Controllers\User'], static function ($routes) {
    $routes->get('login', 'Login::index', ['filter' => 'auth']);
    $routes->get('logout', 'Logout::index');
    $routes->get('register', 'Register::index', ['filter' => 'auth']);
});
