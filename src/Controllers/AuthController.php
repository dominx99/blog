<?php

namespace dominx99\school\Controllers;

use Respect\Validation\Validator as v;

use dominx99\school\Models\User;
use dominx99\school\Auth\Auth;

/**
 * @property object $validator
 * @property object $router
 */
class AuthController extends Controller
{
    public function register($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => v::notEmpty()->email(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::notEmpty()->length(6, 16)
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('register'));
        }

        $params = $request->getParams();

        $user = User::create([
            'email' => $params['email'],
            'name' => $params['name'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ]);

        Auth::authorize($user->id);

        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
