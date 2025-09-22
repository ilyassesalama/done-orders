<?php
namespace App\Controllers;

use App\Firebase;
use Ramsey\Uuid\Uuid;

class OrderController {
    private $ordersPath = 'orders';
    private $db;

    public function __construct() {
        $this->db = Firebase::db();
    }

    public function createOrder($data) {
        $id = Uuid::uuid4();
        $data['id'] = $id;
        $this->db->getReference($this->ordersPath . '/' . $id)->set($data);
        return $id;
    }

    public function getOrders() {
        $ordersData = $this->db->getReference($this->ordersPath)
            ->orderByChild('status')
            ->equalTo('new')
            ->getValue();

        return array_values($ordersData);
    }

    public function getOrder($id) {
        return $this->db->getReference($this->ordersPath . '/' . $id)->getValue();
    }

    public function orderExists($id) {
        $snapshot = $this->db->getReference($this->ordersPath . '/' . $id)->getSnapshot();
        return $snapshot->exists();
    }

    public function deleteOrder($id) {
        $this->db->getReference($this->ordersPath . '/' . $id)->remove();
    }
}
