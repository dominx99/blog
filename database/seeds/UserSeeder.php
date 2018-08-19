<?php

use dominx99\school\Models\User;

class UserSeeder extends BaseSeeder
{
    const FAKE_DATA = false;

    /**
     * Run Method.
     */
    public function run()
    {
        if (static::FAKE_DATA) {
            $users = $this->factory->of(User::class)->times(20)->create();
        }

        User::create([
            'email'    => 'aaa@aaa.com',
            'name'     => 'aaa',
            'password' => password_hash('abcdef', PASSWORD_DEFAULT),
        ]);
    }
}
