<?php
namespace App\Controllers;

use App\Firebase;

class OrderController {
    private $ordersPath = 'orders';
    private $db;

    public function __construct() {
        $this->db = Firebase::db();
    }

    public function createOrder($data) {
        return $this->db->getReference($this->ordersPath)->push($data)->getKey();
    }

    public function updateOrderStatus($id, $data) {
        $this->db->getReference($this->ordersPath.'/'.$id)->update($data);
    }

    public function getOrders() {
        $ordersData = $this->db->getReference($this->ordersPath)->getValue();
        
        if (!$ordersData) {
            return [];
        }
        
        // remove null records
        $validOrders = array_filter($ordersData);

        return array_values($validOrders);
    }

    public function getOrder($id) {
        return $this->db->getReference($this->ordersPath.'/'.$id)->getValue();
    }

    public function orderExists($id) {
        $snapshot = $this->db->getReference($this->ordersPath.'/'.$id)->getSnapshot();
        return $snapshot->exists();
    }
}
