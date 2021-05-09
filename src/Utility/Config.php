<?php


namespace Utility;


class Config
{
    private static $_config = [];

    public static function get($key)
    {
        if (empty(self::$_config)) {
            self::$_config = require_once __DIR__ . '/../../config/config.php';
        }

        return(array_key_exists($key, self::$_config) ? self::$_config[$key] : null);
    }
}