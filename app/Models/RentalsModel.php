<?php namespace App\Models;

use CodeIgniter\Model;

class RentalsModel extends Model {
    protected $table = 'rentals';
    protected $allowedFields = ['id', 'product_id', 'bundle_id', 'rental_detail', 'rental_product_type', 'user_id', 'order_id', 'rent_start_date', 'rent_end_date', 'updated_by', 'status'];

    public function getRentals($id = false) {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->asArray()
                    ->where(['id' => $id])
                    ->first();
    }

    public function getRentalsByUserId($user_id) {
        //get all rentals by user_id, join with products table if rental_product_type is product and join with bundles table if rental_product_type is bundle
        $builder = $this->db->table('rentals');
        $builder->select('rentals.id, rentals.product_id, rentals.bundle_id, rentals.rental_detail, rentals.rental_product_type, rentals.user_id, rentals.order_id, rentals.rent_start_date, rentals.rent_end_date, rentals.updated_by, rentals.status, products.name as product_name, products.sales_price as product_price, bundles.name as bundle_name, bundles.sales_price as bundle_price');
        $builder->join('products', 'products.id = rentals.product_id', 'left');
        $builder->join('bundles', 'bundles.id = rentals.bundle_id', 'left');
        $builder->where('rentals.user_id', $user_id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getRentalById($id, $user_id) {
        $builder = $this->db->table('rentals');
        $builder->select('rentals.id, rentals.product_id, rentals.bundle_id, rentals.rental_detail, rentals.rental_product_type, rentals.user_id, rentals.order_id, rentals.rent_start_date, rentals.rent_end_date, rentals.updated_by, rentals.status, rentals.created_at, products.name as product_name, products.sales_price as product_price, bundles.name as bundle_name, bundles.sales_price as bundle_price');
        $builder->join('products', 'products.id = rentals.product_id', 'left');
        $builder->join('bundles', 'bundles.id = rentals.bundle_id', 'left');
        $builder->where('rentals.id', $id);
        $builder->where('rentals.user_id', $user_id);
        $query = $builder->get();
        return $query->getRow();
    }
}