<?php

namespace App\Providers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

/**
 * Firebase Service Provider
 * 
 * This class provides access to Firebase services using the Singleton pattern.
 * It handles the initialization and configuration of Firebase connections.
 */
class FirebaseServiceProvider
{
    private static ?Database $database = null;
    private static ?array $config = null;
    private static ?Factory $factory = null;

    /**
     * Load and cache the configuration file
     * 
     * @return array Configuration array
     */
    private static function getConfig(): array
    {
        if (self::$config === null) {
            self::$config = require __DIR__ . '/../../config.php';
        }
        return self::$config;
    }

    /**
     * Get Firebase Factory instance
     * 
     * @return Factory Firebase factory instance
     */
    private static function getFactory(): Factory
    {
        if (self::$factory === null) {
            $config = self::getConfig();
            self::$factory = (new Factory)
                ->withServiceAccount($config['firebase']['service_account_path'])
                ->withDatabaseUri($config['firebase']['database_url']);
        }
        return self::$factory;
    }

    /**
     * Get Firebase Realtime Database instance
     * 
     * @return Database Firebase database instance
     */
    public static function database(): Database
    {
        if (self::$database === null) {
            self::$database = self::getFactory()->createDatabase();
        }
        return self::$database;
    }
}
