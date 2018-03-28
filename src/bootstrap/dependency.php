<?php

$container = $app->getContainer();
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};
