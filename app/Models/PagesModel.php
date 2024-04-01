<?php
namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $returnType = 'array';    
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'data', 'page', 'last_update', 'template_id'];

    public function retrievePageData($slug)
    {
        $this->select('data');
        return $this->where('page', $slug)->first();
    }

    public function addNewsletter($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('newsletter_subscribers');
        $builder->insert($data);

        return $this->insertID();
    }
}

