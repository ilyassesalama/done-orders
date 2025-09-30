<?php

namespace App\Controllers;

use App\Services\OrderService;

class OrderController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function createOrder(array $data): string
    {
        return $this->orderService->createOrder($data);
    }

    public function updateOrderStatus(string $id, string $status): void
    {
        $timestamp = time() * 1000;
        $this->orderService->updateOrderStatus($id, $status, $timestamp);
    }

    public function orderExists(string $id): bool
    {
        return $this->orderService->orderExists($id);
    }

    public function createNewOrder(string $title, float $totalPrice, string $image): string
    {
        return $this->orderService->createNewOrder($title, $totalPrice, $image);
    }
}
