<?php

/**
 * Turn on Csrf Protection when environment is not "testing"
 */
if (PHP_SAPI != 'cli') {
    $app->add($container->get('guard'));
}

/**
 * Everyone can access those routes
 */
$app->group('/', function () use ($app) {
    $app->get('docs', 'DocsController:index')->setName('docs');
});

/**
 * Access Only as Guest
 */
$app->group('/', function () use ($app) {
    $app->get('', function () use ($app) {
        return 'home';
    })->setName('home');

    $app->get('register', 'AuthController:registerForm')->setName('auth.register');
    $app->post('register', 'AuthController:register');

    $app->get('login', 'AuthController:loginForm')->setName('auth.login');
    $app->post('login', 'AuthController:login');

    $app->get('auth/{provider}', 'SocialiteController:auth')->setName('auth.provider');
    $app->get('redirect/{provider}', 'SocialiteController:handle');
})->add(new \dominx99\school\Middleware\GuestMiddleware($container));

/**
 * Access Only as Authorized User
 */
$app->group('/', function () use ($app) {
    $app->get('dashboard', function () {
        return 'dashboard';
    })->setName('dashboard');
})->add(new \dominx99\school\Middleware\AuthMiddleware($container));
