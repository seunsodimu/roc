<?php namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PagesModel;
use App\Models\SupportModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response\JSON;

class SupportController extends Controller {

    public function __construct() {
        
    }

    public function index()
    {

    }

    public function supportRequest()
    {
        $support = new SupportModel();
        $data = [
            'request_type' => $this->request->getVar('supportType'),
            'request_subject' => $this->request->getVar('subject'),
            'request' => $this->request->getVar('message'),
            'status' => 'open',
            'requester' => session()->get('user_id'),
            'rental_id' => $this->request->getVar('rentalId')
        ];
        $support->createSupportRequest($data);
        return json_encode(['status' => 'success', 'message' => 'Support request created successfully']);
        
    }


}