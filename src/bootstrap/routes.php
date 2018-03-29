<?php

$app->get('/', function ($request, $response) {
    return 'home';
})->setName('home');

$app->post('/auth', function ($request, $response) use ($container) {
    return $response->withRedirect($container->router->pathFor('home'));
});
