<?php namespace App\Models;

use CodeIgniter\Model;

class ShippingModel extends Model {
    protected $table = 'shipping_options';
    protected $allowedFields = ['shipper', 'name', 'type', 'price', 'status'];
    

}