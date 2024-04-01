<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model {
    protected $table = 'orders';
    protected $allowedFields = ['user_id', 'total', 'status', 'payment_status', 'payment_method', 'shipping_address', 'billing_address', 'shipping_method', 'shipping_cost', 'tax', 'discount', 'grand_total', 'notes', 'created_at', 'updated_at'];

    public function getOrders() {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*, users.first_name, users.last_name');
        $builder->join('users', 'users.id = orders.user_id', 'left');
        $builder->orderBy('orders.created_at', 'desc');
        return $builder->get()->getResultArray();
    }

    public function getOrderById($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->where('orders.id', $id);
        $builder->select('orders.*, users.first_name, users.last_name');
        $builder->join('users', 'users.id = orders.user_id', 'left');
        return $builder->get()->getRowArray();
    }

    public function getOrdersByUserId($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->where('transactions.user_id', $userId);
        $builder->select('transactions.*, users.first_name, users.last_name');
        $builder->join('users', 'users.id = transactions.user_id', 'left');
        $builder->orderBy('transactions.created_date', 'desc');
        return $builder->get()->getResultArray();
    }
}