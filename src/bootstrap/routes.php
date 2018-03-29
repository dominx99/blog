<?php

$app->get('/', function () {
    return 'home';
})->setName('home');

$app->get('/register', 'AuthController:registerForm')->setName('register');
$app->post('/register', 'AuthController:register');

$app->get('/dashboard', function() {
    return 'dashboard';
})->setName('dashboard');
