<?php

namespace dominx99\school\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use dominx99\school\Models\User;
use dominx99\school\Config;

class Auth
{
    /**
     * @param int $user user id
     * Sets user session
     */
    public static function authorize($user):void
    {
        $_SESSION['user'] = $user;
    }

    /**
     * Removes User session
     */
    public static function logout():void
    {
        unset($_SESSION['user']);
    }

    /**
     * @return boolean true if user is logged in, session exists; false when session does not exist
     */
    public static function check():bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @param string $email
     * @param string $password
     * @return boolean true if user exists, false if user does not exist
     * In addition this method automatically auth user
     */
    public static function attempt($email, $password):bool
    {
        if (!$user = User::where('email', $email)->first()) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        self::authorize($user->id);
        return true;
    }

    /**
     * @return User|false returns User model instance which is logged in
     */
    public static function user()
    {
        if (isset($_SESSION['user'])) {
            return User::find($_SESSION['user']);
        }
        return false;
    }

    /**
     * @return string $token
     * Function generates token from authorized User Id
     */
    public static function getToken():string
    {
        $key = Config::get('jwtKey');
        $signer = new Sha256();

        $token = (string) (new Builder)
            ->set('id', static::user()->id)
            ->sign($signer, $key)
            ->getToken();

        return $token;
    }
}
