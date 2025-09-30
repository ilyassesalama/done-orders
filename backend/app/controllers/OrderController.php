<?php

namespace App\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\OrderService;
use App\Validators\OrderValidator;

class OrderController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function index(): void
    {
        ResponseHelper::json(['message' => 'hello done!']);
    }

    public function store(): void
    {
        $data = ResponseHelper::getJsonInput();

        OrderValidator::validateOrderFields($data);

        $id = $this->orderService->createNewOrder(
            $data['title'],
            $data['total_price'],
            $data['image']
        );

        ResponseHelper::json(['id' => $id], 201);
    }

    public function update(string $id): void
    {
        OrderValidator::validateStatusUpdate($_GET);

        if (!$this->orderService->orderExists($id)) {
            ResponseHelper::error('Order not found.', 404);
        }

        $status = $_GET['status'];
        $timestamp = time() * 1000;

        $this->orderService->updateOrderStatus($id, $status, $timestamp);

        ResponseHelper::json(['message' => 'Order status updated successfully.']);
    }
    public function seed(): void
    {
        $foodItems = [
            'Margherita Pizza',
            'Cheeseburger',
            'Caesar Salad',
            'Chicken Tikka Masala',
            'Sushi Roll',
            'Fish & Chips',
            'Beef Tacos',
            'Pad Thai',
            'Ramen Bowl',
            'Greek Salad',
            'BBQ Ribs',
            'Chicken Wings',
            'Steak Frites',
            'Veggie Burger',
            'Seafood Pasta',
            'Butter Chicken',
            'Korean BBQ',
            'Fish Curry',
            'Lamb Shawarma',
            'Poke Bowl',
            'Chicken Sandwich',
            'Mushroom Risotto',
            'Beef Burger',
            'Grilled Salmon',
            'Chicken Wrap'
        ];

        $foodImages = [
            'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=300&fit=crop',
            'https://done.ma/app/uploads/2025/05/cover-9-2048x856.png',
            'https://done.ma/app/uploads/2025/05/cover-7-2048x856.png',
            'https://done.ma/app/uploads/2025/05/cover-8-2048x856.png',
            'https://done.ma/app/uploads/2025/04/darEnnaji-2048x1567.jpg',
            'https://thumbs.dreamstime.com/b/unhealthy-fast-food-delivery-menu-featuring-assorted-burgers-cheeseburgers-nuggets-french-fries-soda-high-calorie-low-356045884.jpg'
        ];

        $statuses = ['new', 'delivered', 'cancelled'];
        $currentTime = time() * 1000;
        $orderCount = rand(15, 25);
        $createdOrders = [];

        for ($i = 0; $i < $orderCount; $i++) {
            $title = $foodItems[array_rand($foodItems)];
            $image = $foodImages[array_rand($foodImages)];
            $totalPrice = round(rand(15, 150) + (rand(0, 99) / 100), 2);
            $status = $statuses[array_rand($statuses)];
            $placedAt = $currentTime - rand(0, 30 * 24 * 60 * 60) * 1000;

            $orderData = [
                'title' => $title,
                'total_price' => $totalPrice,
                'image' => $image,
                'placed_at' => $placedAt,
                'status' => $status,
                'delivered_at' => $status === 'delivered' ? $placedAt + rand(1 * 24 * 60 * 60, 7 * 24 * 60 * 60) * 1000 : null,
                'cancelled_at' => $status === 'cancelled' ? $placedAt + rand(1 * 24 * 60 * 60, 3 * 24 * 60 * 60) * 1000 : null
            ];

            $orderId = $this->orderService->createOrder($orderData);

            $createdOrders[] = [
                'id' => $orderId,
                'title' => $title,
                'status' => $status,
                'total_price' => $totalPrice
            ];
        }

        ResponseHelper::json([
            'message' => "Successfully seeded {$orderCount} random food orders.",
            'orders' => $createdOrders
        ]);
    }
}