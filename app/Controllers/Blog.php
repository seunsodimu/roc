<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Auth;
use App\Models\Categories;
use App\Models\Posts;
use App\Models\PagesModel;

class Blog extends BaseController
{
    public $session;
    public $db;
    public $auth_model;
    public $category_model;
    public $post_model;
    public $data;
    
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->db = db_connect();
        $this->auth_model = new Auth;
        $this->category_model = new Categories;
        $this->post_model = new Posts;
        $menu_cat = $this->category_model->select("id, name")->orderBy('name','asc')->limit(3)->find();
        $this->data = ['session' => $this->session,'request'=>$this->request, 'menu_cat' => $menu_cat];
        
    }

    public function index()
    {
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->post_model->where('posts.status', 1)
                                ->orderBy('abs(unix_timestamp(posts.created_at)) DESC')
                                ->countAllResults();
        $this->data['posts'] = $this->post_model->where('posts.status', 1)
                                ->select("posts.*, CONCAT(users.first_name, ' ',users.last_name) as author, categories.name as category, categories.id as category_id")
                                ->join('users',"posts.user_id = users.id", "inner")
                                ->join('categories',"posts.category_id = categories.id", "inner")
                                ->orderBy('abs(unix_timestamp(posts.created_at)) DESC')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['posts'])? count($this->data['posts']) : 0;
        $this->data['pager'] = $this->post_model->pager;
        $this->data['categories'] = $this->category_model->orderBy('abs((categories.name)) asc')->findAll();
        
        $pagesModel = new PagesModel();
        $homeData = $pagesModel->retrievePageData('blog');
        $data = [
            'page_title' => $this->findSection($homeData['data'], 'page_title'),
            'meta_tags' => $this->findSection($homeData['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($homeData['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($homeData['data'], 'page_top_promo'),
            'banner' => $this->findSection($homeData['data'], 'banner'),
            'page_body' => $this->findSection($homeData['data'], 'page_body'),
            'blog_data' => $this->data,
            'active' => 'blog'
        ];
        //  var_dump($data['blog_data']['pager']); exit;
        return view('blog', ['data' => $data]);
    }
    
    public function categories()
    {
        $this->data['page_title'] = "Categories";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->category_model->orderBy('abs((name)) asc')
                                ->countAllResults();
        $this->data['categories'] = $this->category_model->orderBy('abs((name)) asc')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['categories'])? count($this->data['categories']) : 0;
        $this->data['pager'] = $this->category_model->pager;
        
        
        return view('pages/public/categories', $this->data);
    }
    
    public function category($id="")
    {
        if(empty($id))
        return redirect()->to('Blog/PagenotFound');
        
        $category = $this->category_model->where('id',$id)->first();
        if(!isset($category['id']))
            return redirect()->to('Blog/PagenotFound');
        $this->data['page_title'] = $category['name'];
        $this->data['category'] = $category;
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->post_model
                                ->where('status', 1)
                                ->where('category_id', $id)
                                ->orderBy('abs(unix_timestamp(created_at)) DESC')
                                ->countAllResults();
        $this->data['posts'] = $this->post_model
                                ->where('posts.status', 1)
                                ->where('posts.category_id', $id)
                                ->select("posts.*, CONCAT(users.first_name, ' ',users.last_name) as author, categories.name as category, categories.id as category_id")
                                ->join('users',"posts.user_id = users.id", "inner")
                                ->join('categories',"posts.category_id = categories.id", "inner")
                                ->orderBy('abs(unix_timestamp(posts.created_at)) DESC')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['posts'])? count($this->data['posts']) : 0;
        $this->data['pager'] = $this->post_model->pager;
        $this->data['categories'] = $this->category_model->orderBy('abs((name)) asc')->findAll();
        $pagesModel = new PagesModel();
        $homeData = $pagesModel->retrievePageData('blog');
        $data = [
            'meta_tags' => $this->findSection($homeData['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($homeData['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($homeData['data'], 'page_top_promo'),
            'banner' => $this->findSection($homeData['data'], 'banner'),
            'page_body' => $this->findSection($homeData['data'], 'page_body'),
            'blog_data' => $this->data,
            'active' => 'blog'
        ];
        $data['page_title']['title'] = $category['name'].' Posts';
        $data['banner']['title'] = $category['name'].' Posts';
        return view('blog', ['data' => $data]);
    }
    public function view($slug = ''){
        if(empty($slug))
        return redirect()->to('Blog/PagenotFound');
        $post = $this->post_model
                     ->select("posts.*, CONCAT(users.first_name, ' ',users.last_name) as author, categories.name as category, categories.id as category_id")
                     ->where("posts.slug = '{$slug}'")
                     ->join('users',"posts.user_id = users.id", "inner")
                     ->join('categories',"posts.user_id = categories.id", "inner")
                     ->first();
        if(!isset($post['id']))
        return redirect()->to('Blog/PagenotFound');
        $this->data['post'] = $post;
        $pagesModel = new PagesModel();
        $homeData = $pagesModel->retrievePageData('blog');
        $data['page_title']['title'] = $post['title'];
        $data = [
            'meta_tags' => $this->findSection($homeData['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($homeData['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($homeData['data'], 'page_top_promo'),
            'banner' => $this->findSection($homeData['data'], 'banner'),
            'page_body' => $this->findSection($homeData['data'], 'page_body'),
            'post_data' => $this->data,
            'active' => 'blog'
        ];
        // var_dump($data['page_title']); exit;
        return view('post', ['data' => $data]);
    }
    public function PagenotFound(){
        $this->data['page_title'] = "Page Not Found";
        return view('pages/public/page_not_found', $this->data);
    }

    private function findSection($jsonContent, $itemName) 
    {
        $dataArray = json_decode($jsonContent, true);
    
        foreach ($dataArray['sections'] as $section) {
            if (($section['section'] ?? '') === $itemName) {
                return $section;
            }
        }

    return false;
}
}
