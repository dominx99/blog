<?php

$app->group('/api', function () use ($app) {
    $app->post('/register', 'ApiAuthController:register');
});
