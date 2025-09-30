<?php

namespace App\Services;

use App\Providers\FirebaseServiceProvider;
use Ramsey\Uuid\Uuid;
use Kreait\Firebase\Database;

class OrderService
{
    private Database $db;
    private string $ordersPath = 'orders';

    public function __construct()
    {
        $this->db = FirebaseServiceProvider::database();
    }

    /**
     * Create a new order in Firebase
     * 
     * @param array $orderData Order data to be created
     * @return string UUID of the created order
     */
    public function createOrder(array $orderData): string
    {
        $id = Uuid::uuid4()->toString();
        $orderData['id'] = $id;

        $this->db->getReference($this->ordersPath . '/' . $id)->set($orderData);

        return $id;
    }

    /**
     * Update order status
     * 
     * @param string $id Order ID
     * @param string $status New status (delivered, cancelled)
     * @param int $timestamp Timestamp in milliseconds
     * @return void
     */
    public function updateOrderStatus(string $id, string $status, int $timestamp): void
    {
        $eventField = $status === 'delivered' ? 'delivered_at' : 'cancelled_at';

        $this->db->getReference($this->ordersPath . '/' . $id)->update([
            'status' => $status,
            $eventField => $timestamp
        ]);
    }

    /**
     * Check if an order exists
     * 
     * @param string $id Order ID
     * @return bool True if order exists, false otherwise
     */
    public function orderExists(string $id): bool
    {
        $snapshot = $this->db->getReference($this->ordersPath . '/' . $id)->getSnapshot();
        return $snapshot->exists();
    }

    /**
     * Create an order with default values
     * 
     * @param string $title Order title
     * @param float $totalPrice Total price
     * @param string $image Image URL
     * @return string UUID of the created order
     */
    public function createNewOrder(string $title, float $totalPrice, string $image): string
    {
        $orderData = [
            'title' => $title,
            'total_price' => $totalPrice,
            'image' => $image,
            'placed_at' => time() * 1000,
            'delivered_at' => null,
            'cancelled_at' => null,
            'status' => 'new',
        ];

        return $this->createOrder($orderData);
    }
}
