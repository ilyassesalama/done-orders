<?php

use Dotenv\Dotenv;

// load environment variables
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

return [
    // firebase configuration
    'firebase' => [
        'database_url' => $_SERVER['FIREBASE_DATABASE_URL'] ?? '',
        'service_account_json' => $_SERVER['FIREBASE_SERVICE_ACCOUNT'] ?? '',
    ],

    // cors configuration
    'cors' => [
        'allowed_origin' => $_SERVER['ALLOWED_ORIGIN'] ?? 'http://localhost:5173',
        'allowed_methods' => 'GET, POST, PATCH, OPTIONS',
        'allowed_headers' => 'Content-Type',
    ],

    // application environment
    'app' => [
        'env' => $_SERVER['APP_ENV'] ?? 'development',
        'debug' => ($_SERVER['APP_DEBUG'] ?? 'true') === 'true',
    ],
];
