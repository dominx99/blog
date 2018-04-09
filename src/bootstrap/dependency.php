<?php

$container = $app->getContainer();

$container['db'] = function () use ($capsule) {
    return $capsule;
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
