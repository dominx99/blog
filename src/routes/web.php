<?php

use dominx99\school\Config;

/**
 * Turn on Csrf Protection when environment is not "testing"
 */
if (Config::get('environment') != 'testing') {
    $app->add($container->get('csrf'));
}

/**
 * Access Only as Guest
 */
$app->group('/', function () use ($app) {

    $app->get('/', function () use ($app) {
        return 'home';
    })->setName('home');

    $app->get('register', 'AuthController:registerForm')->setName('register');
    $app->post('register', 'AuthController:register');

    $app->get('login', 'AuthController:loginForm')->setName('login');
    $app->post('login', 'AuthController:login');

})->add(new \dominx99\school\Middleware\GuestMiddleware($container));

/**
 * Access Only as Authorized User
 */
$app->group('/', function () use ($app) {

    $app->get('dashboard', function () {
        return 'dashboard';
    })->setName('dashboard');

})->add(new \dominx99\school\Middleware\AuthMiddleware($container));
