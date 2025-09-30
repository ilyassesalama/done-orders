<?php

namespace App\Validators;

use App\Helpers\ResponseHelper;

/**
 * Order Validator
 * 
 * Handles validation logic for order-related operations
 */
class OrderValidator
{
    /**
     * Validate order creation fields
     * 
     * @param array $data Data to validate
     * @return void Exits with error response if validation fails
     */
    public static function validateOrderFields(array $data): void
    {
        // check if all required fields are set
        if (!isset($data['title']) || !isset($data['total_price']) || !isset($data['image'])) {
            ResponseHelper::error('You must supply all required fields: title, total_price, and image');
        }

        // check if total_price is a number
        if (!is_numeric($data['total_price'])) {
            ResponseHelper::error('Total price must be a number');
        }

        // check if total_price is positive
        if ($data['total_price'] <= 0) {
            ResponseHelper::error('Total price must be greater than zero');
        }

        // check if title is at least 5 characters long
        if (strlen(trim($data['title'])) <= 5) {
            ResponseHelper::error('Title must be at least 5 characters long');
        }

        // check if image is a valid URL
        if (!filter_var($data['image'], FILTER_VALIDATE_URL)) {
            ResponseHelper::error('Image must be a valid URL');
        }
    }

    /**
     * Validate order status update request
     * 
     * @param array $queryParams Query parameters ($_GET)
     * @return void Exits with error response if validation fails
     */
    public static function validateStatusUpdate(array $queryParams): void
    {
        // check if status parameter exists
        if (!isset($queryParams['status'])) {
            ResponseHelper::error('Order status is required.');
        }

        // check if status value is valid
        if (!self::isValidUpdateStatus($queryParams['status'])) {
            ResponseHelper::error('Invalid order status. Allowed values: delivered, cancelled');
        }
    }

    /**
     * Validate order status value
     * 
     * @param string $status Status to validate
     * @return bool True if valid, false otherwise
     */
    public static function isValidStatus(string $status): bool
    {
        $allowedStatuses = ['new', 'delivered', 'cancelled'];
        return in_array($status, $allowedStatuses);
    }

    /**
     * Validate order update status value
     * 
     * @param string $status Status to validate
     * @return bool True if valid, false otherwise
     */
    public static function isValidUpdateStatus(string $status): bool
    {
        $allowedStatuses = ['delivered', 'cancelled'];
        return in_array($status, $allowedStatuses);
    }
}
