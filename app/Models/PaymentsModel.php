<?php namespace App\Models;

use CodeIgniter\Model;

class PaymentsModel extends Model {
    protected $table = 'payment_methods';
    protected $allowedFields = ['id', 'name', 'last_four', 'user_id', 'status', 'is_default'];

    public function getPaymentMethods() {
        $db = \Config\Database::connect();
        $builder = $db->table('payment_methods');
        $builder->where('status', 'active');
        return $builder->get()->getResultArray();
    }

    public function getPaymentMethodById($id) {
        return $this->asArray()->where(['id' => $id])->first();
    }

    public function getPaymentMethodsByUserId($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('payment_methods');
        $builder->where('user_id', $userId);
        return $builder->get()->getResultArray();
    }

    public function createTransaction($data) {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->insert($data);
        return $db->insertID();
    }

    public function getTransactionById($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    public function saveCart($data) {
        $db = \Config\Database::connect();
        $builder = $db->table('saved_cart');
        $builder->insert($data);
        return $db->insertID();
    }

    public function getSavedCarts($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('saved_cart');
        $builder->where('user_id', $userId);
        return $builder->get()->getResultArray();
    }

    public function getSavedCartById($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('saved_cart');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    
    public function deleteSavedCart($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('saved_cart');
        $builder->where('id', $id);
        $builder->delete();
        return $db->affectedRows();
    }

    public function updateSavedCart($id, $data) {
        $db = \Config\Database::connect();
        $builder = $db->table('saved_cart');
        $builder->where('id', $id);
        $builder->update($data);
        return $db->affectedRows();
    }
}