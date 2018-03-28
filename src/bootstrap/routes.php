<?php

$app->get('/', function ($request, $response) {
    return 'home';
})->setName('home');

$app->post('/auth', function ($request, $response) {
    return $response->withRedirect($this->router->pathFor('home'));
});
