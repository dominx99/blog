<?php

$container = $app->getContainer();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('resources/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['csrf'] = function () {
    return new \Slim\Csrf\Guard;
};

$container['validator'] = function () {
    return new \dominx99\school\Validation\Validator;
};

$container['AuthController'] = function ($container) {
    return new \dominx99\school\Controllers\AuthController($container);
};

$container['ApiAuthController'] = function ($container) {
    return new \dominx99\school\Controllers\Api\ApiAuthController($container);
};
