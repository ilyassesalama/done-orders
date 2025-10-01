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
        'database_url' => getenv('FIREBASE_DATABASE_URL') ?: '',
        'service_account_json' => getenv('FIREBASE_SERVICE_ACCOUNT') ?: '',
    ],

    // cors configuration
    'cors' => [
        'allowed_origin' => getenv('ALLOWED_ORIGIN') ?: 'http://localhost:5173',
        'allowed_methods' => 'GET, POST, PATCH, OPTIONS',
        'allowed_headers' => 'Content-Type',
    ],
];
