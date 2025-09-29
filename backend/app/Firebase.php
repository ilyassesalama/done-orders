<?php

namespace App;

use Kreait\Firebase\Factory;

class Firebase
{
    private static $database;
    private static $config = null;

    private static function getConfig()
    {
        if (self::$config === null) {
            self::$config = require __DIR__ . '/../config.php';
        }
        return self::$config;
    }

    public static function db()
    {
        if (!self::$database) {
            $config = self::getConfig();
            $factory = (new Factory)
                ->withServiceAccount($config['firebase']['service_account_path'])
                ->withDatabaseUri($config['firebase']['database_url']);
            self::$database = $factory->createDatabase();
        }
        return self::$database;
    }
}
