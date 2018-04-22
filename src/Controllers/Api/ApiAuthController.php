<?php

namespace dominx99\school\Controllers\Api;

use Respect\Validation\Validator as v;
use dominx99\school\Controllers\Controller;
use dominx99\school\Models\User;
use dominx99\school\Auth\Auth;

/**
 * @property object validator
 */
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

        $user = User::create([
            'email' => $params['email'],
            'name' => $params['name'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ]);

        Auth::authorize($user->id);
        $token = Auth::getToken();

        return $response->WithJson([
            'token' => $token,
            'status' => 'success',
            'code' => 200
        ]);
    }

    public function login($request, $response)
    {
        $params = $request->getParsedBody();

        if (!Auth::attempt($params['email'], $params['password'])) {
            return $response->WithJson([
                'status' => 'fail',
                'code' => 301
            ]);
        }

        $token = Auth::getToken();

        return $response->WithJson([
            'token' => $token,
            'status' => 'success',
            'code' => 200
        ]);
    }
}
