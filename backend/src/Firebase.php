<?php
namespace App;

use Kreait\Firebase\Factory;

class Firebase {
    private static $database;

    public static function db() {
        if (!self::$database) {
            $factory = (new Factory)
                ->withServiceAccount(__DIR__.'/firebase-service-account.json')
                ->withDatabaseUri('https://donedotma-default-rtdb.europe-west1.firebasedatabase.app/');
            self::$database = $factory->createDatabase();
        }
        return self::$database;
    }
}
