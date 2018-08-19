<?php

use dominx99\school\Models\User;

$this->factory->define(User::class, function (\Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'email'    => $faker->email,
        'password' => password_hash($faker->password, PASSWORD_DEFAULT),
    ];
});
