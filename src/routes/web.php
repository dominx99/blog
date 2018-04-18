<?php

use dominx99\school\Config;

if (Config::get('environment') != 'testing') {
    $app->add($container->get('csrf'));
}

$app->get('/', function () use ($app) {
    return 'home';
})->setName('home');

$app->get('/register', 'AuthController:registerForm')->setName('register');
$app->post('/register', 'AuthController:register');

$app->get('/login', 'AuthController:loginForm')->setName('login');
$app->post('/login', 'AuthController:login');

$app->get('/dashboard', function () {
    return 'dashboard';
})->setName('dashboard');
