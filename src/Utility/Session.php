<?php


namespace Utility;


class Session
{
    public static function init()
    {
        if (session_id() == '') {
            session_start();
        }
    }

    public static function exists($key): bool
    {
        return(isset($_SESSION[$key]));
    }

    public static function get($key) {
        if (self::exists($key)) {
            return($_SESSION[$key]);
        }
        return null;
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function delete($key): bool
    {
        if (self::exists($key)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    public static function  put($key, $value)
    {
        return($_SESSION[$key] = $value);
    }
}