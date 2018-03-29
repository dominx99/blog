<?php

$container = $app->getContainer();
$container['db'] = function () use ($capsule) {
    return $capsule;
};
