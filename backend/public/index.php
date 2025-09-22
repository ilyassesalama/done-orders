<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\OrderController;
use App\Utils\ResponseUtil;
use App\Utils\ValidationUtil;
use Bramus\Router\Router;

// set CORS headers (this is too strict imo, but i added this to demonstrate how cors work)
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$router = new Router();
$controller = new OrderController();

// handle preflight OPTIONS requests for CORS
$router->options('/.*', function () {
    http_response_code(200);
    exit();
});

// health check
$router->get('/', function () {
    ResponseUtil::json(['message' => 'The API is working!']);
});

// list all orders
$router->get('/orders', function () use ($controller) {
    $orders = $controller->getOrders();
    ResponseUtil::success($orders);
});

// create new order
$router->post('/orders', function () use ($controller) {
    $data = json_decode(file_get_contents('php://input'), true);

    ValidationUtil::validateOrderFields($data); // if validation fails, this will stop here

    $title = $data['title'];
    $total_price = $data['total_price'];
    $image = $data['image'];
    $placed_at = time() * 1000;
    $delivered_at = null;
    $cancelled_at = null;
    $status = 'new';

    $data = [
        'title' => $title,
        'total_price' => $total_price,
        'image' => $image,
        'placed_at' => $placed_at,
        'delivered_at' => $delivered_at,
        'cancelled_at' => $cancelled_at,
        'status' => $status,
    ];

    $id = $controller->createOrder($data);
    ResponseUtil::json(['id' => $id], 201);
});

// check if order exists
$router->get('/orders/([a-f0-9\-]+)/exists', function ($id) use ($controller) { // only allow hex values and -
    $exists = $controller->orderExists($id);
    ResponseUtil::success(['exists' => $exists]);
});

// update order status
$router->patch('/orders/([a-f0-9\-]+)', function ($id) use ($controller) {
    if (!isset($_GET['status'])) {
        ResponseUtil::error('Status parameter is required');
    }

    $status = $_GET['status'];

    $allowedStatuses = ['delivered', 'cancelled'];
    if (!in_array($status, $allowedStatuses)) {
        ResponseUtil::error('Invalid status. Allowed values: ' . implode(', ', $allowedStatuses));
    }

    if (!$controller->orderExists($id)) {
        ResponseUtil::error('Order not found', 404);
    }

    // just delete the order, no need to update the status, because why?
    $controller->deleteOrder($id);

    ResponseUtil::json(['message' => 'Order status updated and deleted successfully']);
});





// seed random food orders
$router->post('/orders/seed', function () use ($controller) {
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
        $orderId = $controller->createOrder($orderData);
        $createdOrders[] = [
            'id' => $orderId,
            'title' => $title,
            'status' => $status,
            'total_price' => $totalPrice
        ];
    }
    ResponseUtil::json([
        'message' => "Successfully seeded {$orderCount} random food orders",
        'orders' => $createdOrders
    ]);
});



$router->run();
