<?php
namespace App\Utils;

class ValidationUtil {
    public static function validateOrderFields($data) {
        // check if all required fields are set
        if (!isset($data['title']) || !isset($data['total_price']) || !isset($data['image'])) {
            ResponseUtil::error('You must supply all required fields');
        }
    
        // check if total_price is a number
        if (!is_numeric($data['total_price'])) {
            ResponseUtil::error('Total price must be a number');
        }
    
        // check if title is at least 5 characters long
        if (strlen(trim($data['title'])) <= 5) {
            ResponseUtil::error('Title must be at least 5 characters long');
        }
    
        // check if image is a valid URL
        if (!filter_var($data['image'], FILTER_VALIDATE_URL)) {
            ResponseUtil::error('Image must be a valid URL');
        }
    }
}