<?php


namespace Utility;


class Auth
{
    public static function isAuthenticated(): bool
    {
        Session::init();
        if (!Session::exists('user')) {
            return false;
        }
        return true;
    }

    public static function isUnauthenticated(): bool
    {
        Session::init();
        if (Session::exists('user')) {
            return false;
        }
        return true;
    }

    /**
     * @throws \Exception
     */
    public static function login(array $credentials)
    {
        $login = $credentials['login'];
        $password = $credentials['password'];
        $hash = hash('sha256', $password);

        if ($login != Config::get('admin')['login'] or $hash != Config::get('admin')['password_hash']) {
            throw new \Exception('Invalid credentials');
        }
        Session::init();
        Session::put('user', $login);
    }
}