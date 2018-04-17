<?php

namespace dominx99\school\Auth;

use dominx99\school\Models\User;

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
     *  @return User|false returns User model instance which is logged in
     */
    public static function user()
    {
        if (isset($_SESSION['user'])) {
            return User::find($_SESSION['user']);
        }
        return false;
    }
}
