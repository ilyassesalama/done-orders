<?php

namespace App\Helpers;

/**
 * Response Helper
 * 
 * Provides helper methods for sending JSON responses
 */
class ResponseHelper
{
    /**
     * Send a JSON response
     * 
     * @param mixed $data Data to send
     * @param int $statusCode HTTP status code
     * @return void
     */
    public static function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send a success response
     * 
     * @param mixed $data Data to send
     * @return void
     */
    public static function success($data = null): void
    {
        self::json($data);
    }

    /**
     * Send an error response
     * 
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @return void
     */
    public static function error(string $message, int $statusCode = 400): void
    {
        self::json(['error' => $message], $statusCode);
    }

    /**
     * Parse JSON from request body and validate
     * 
     * @return array Parsed JSON data
     */
    public static function getJsonInput(): array
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
            self::error('Invalid JSON payload.');
        }

        return $data;
    }
}
