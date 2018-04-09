<?php

namespace dominx99\school\Controllers\Api;

use Respect\Validation\Validator as v;
use dominx99\school\Controllers\Controller;
use dominx99\school\Models\User;

class ApiAuthController extends Controller
{
    public function register($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => v::notEmpty()->email(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::notEmpty()->length(6, 16)
        ]);

        if ($validation->failed()) {
            return $response->WithJson([
                'status' => 'fail',
                'code' => 300
            ]);
        }

        $params = $request->getParsedBody();

        User::create([
            'email' => $params['email'],
            'name' => $params['name'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ]);

        return $response->WithJson([
            'status' => 'success',
            'code' => 200
        ]);
    }
}
