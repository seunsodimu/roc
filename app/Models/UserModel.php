<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'email', 'password', 'first_name', 'last_name', 'status', 'phone', 'address', 'city', 'state', 'timezone', 'zip'];
    

    

    public function getUser($id)
    {
        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }

    public function getUserByUsername($username)
    {
        return $this->asArray()
            ->where(['username' => $username])
            ->first();
    }

    public function getUserByEmail($email)
    {
        return $this->asArray()
            ->where(['email' => $email])
            ->first();
    }

    public function saveVerificationCode($data)
    {
        //save to verification_codes table
        $db = \Config\Database::connect();
        $builder = $db->table('verification_codes');
        $builder->insert($data);
        return $db->insertID();
    }

    public function getVerificationCode($code)
    {
       $db = \Config\Database::connect();
         $builder = $db->table('verification_codes');
            return $builder->where(['code' => $code])->get()->getRow();
    }

    public function updateVerificationCode($id, $data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('verification_codes');
        $builder->where('id', $id);
        $builder->update($data);
    }
}