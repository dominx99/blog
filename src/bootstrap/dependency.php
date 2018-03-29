<?php

$container = $app->getContainer();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['validator'] = function () {
    return new \dominx99\school\Validation\Validator;
};

$container['AuthController'] = function ($container) {
  return new \dominx99\school\Controllers\AuthController($container);
};
