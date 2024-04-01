<?php namespace App\Models;

use CodeIgniter\Model;

class SupportModel extends Model {

    protected $table = 'support';
    protected $allowedFields = ['requester', 'request_type', 'request_subject', 'request', 'rental_id', 'status', 'created_at', 'updated_at'];

    public function getSupportRequests() {
        $db = \Config\Database::connect();
        $builder = $db->table('support');
        $builder->select('support.*, users.first_name, users.last_name');
        $builder->join('users', 'users.id = support.user_id', 'left');
        $builder->orderBy('support.created_at', 'desc');
        return $builder->get()->getResultArray();
    }

    public function getSupportRequestById($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('support');
        $builder->where('support.id', $id);
        $builder->select('support.*, users.first_name, users.last_name');
        $builder->join('users', 'users.id = support.user_id', 'left');
        return $builder->get()->getRowArray();
    }

    public function getSupportRequestsByUserId($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('support');
        $builder->where('support.user_id', $userId);
        $builder->select('support.*, users.first_name, users.last_name');
        $builder->join('users', 'users.id = support.user_id', 'left');
        $builder->orderBy('support.created_at', 'desc');
        return $builder->get()->getResultArray();
    }

    public function createSupportRequest($data) {
        $db = \Config\Database::connect();
        $builder = $db->table('support');
        $builder->insert($data);
        return $db->insertID();
    }

    public function updateSupportRequest($id, $data) {
        $db = \Config\Database::connect();
        $builder = $db->table('support');
        $builder->where('id', $id);
        $builder->update($data);
        return $db->affectedRows();
    }

    public function deleteSupportRequest($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('support');
        $builder->where('id', $id);
        $builder->delete();
        return $db->affectedRows();
    }
}