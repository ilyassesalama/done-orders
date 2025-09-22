<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\OrderController;
use App\Utils\ResponseUtil;
use App\Utils\ValidationUtil;
use Bramus\Router\Router;

// set CORS headers
header("Access-Control-Allow-Origin: *");

$router = new Router();
$controller = new OrderController();

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
    $placed_at = time();
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
$router->get('/orders/(\w+)/exists', function ($id) use ($controller) {
    $exists = $controller->orderExists($id);
    ResponseUtil::success(['exists' => $exists]);
});

// update order status
$router->patch('/orders/(\w+)', function ($id) use ($controller) {
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

    $controller->updateOrderStatus($id, ['status' => $status]);
    ResponseUtil::json(['message' => 'Order status updated successfully']);
});

$router->run();
