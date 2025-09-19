<?php
namespace App\Utils;

class ResponseUtil {
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    public static function success($data = null) {
        self::json($data);
    }
    
    public static function error($message, $statusCode = 400) {
        self::json(['error' => $message], $statusCode);
    }
}
