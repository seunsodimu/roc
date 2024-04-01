<?php

namespace App\Controllers;

use Predis\Client as Redis;
use App\Models\PagesModel;

class Home extends BaseController
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis([
            'scheme' => 'tcp',
            'host'   => 'localhost',
            'port'   => 6379,
        ]);
    }

    public function index()
    {
        // $homeData = $this->getHomeData();

        // if (!$homeData) {
            $pagesModel = new PagesModel();
            $homeData = $pagesModel->retrievePageData('homepage');
        //     $this->setHomeData($homeData);
        // }
        // $this->load->view('home', ['data' => $homeData]);
        $page_data = json_decode($homeData['data'], true);
        $data = [
            'page_title' => $this->findSection($homeData['data'], 'page_title'),
            'meta_tags' => $this->findSection($homeData['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($homeData['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($homeData['data'], 'page_top_promo'),
            'banner' => $this->findSection($homeData['data'], 'banner'),
            'top_products' => $this->findSection($homeData['data'], 'top_products'),
            'blog' => $this->findSection($homeData['data'], 'blog'),
            'testimonials' => $this->findSection($homeData['data'], 'testimonials'),
            'cta2' => $this->findSection($homeData['data'], 'cta2'),
            'faqs' => $this->findSection($homeData['data'], 'faqs'),
            'cta3' => $this->findSection($homeData['data'], 'cta3'),
            'cta4' => $this->findSection($homeData['data'], 'cta4'),
            'active' => 'home'
        ];
        // var_dump($data['testimonials']['reviews']); exit;
        $page = env('CI_ENVIRONMENT') == 'development' ? 'home' : 'welcome_message';
        return view($page, ['data' => $data]);
    }

    private function getHomeData()
    {
        $homeData = $this->redis->get('home_data');

        if ($homeData && !$this->isExpired($homeData)) {
            return json_decode($homeData, true);
        }

        return null;
    }

    private function isExpired($data)
    {
        $expiry = $this->redis->ttl('home_data');
        return $expiry <= 0;
    }

    private function setHomeData($data)
    {
        $expiryTime = 24 * 60 * 60; // 24 hours
        $this->redis->set('home_data', json_encode($data));
        $this->redis->expire('home_data', $expiryTime);
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

public function addNewsletter()
{
    $email = $this->request->getVar('email');
    $pagesModel = new PagesModel();
    $data = [
        'email' => $email,
        'name'  =>''
    ];
    $pagesModel->addNewsletter($data);
    return json_encode(['status' => 'success', 'message' => 'You have been added to our newsletter list!']);

}

   public function pagenotfound(){
    $data = [
        'page_title' => ['title' => 'Page Not Found'],
            'meta_tags' => ['tags' => []],
            'promo_popup' => ['enabled' => false],
            'page_top_promo' => ['enabled' => false],
            'banner' => ['enabled' => false],
            'active' => 'home'
    ];    
    $message = "The page you were navigating to seems to have floated away.<br>Try paddling back to the <a href='".base_url()."'>home page</a>.";
    $title = "Upstream Without a Paddle!";
    return view('errors/html/error_404', ['data' => $data, 'message'=> $message, 'title'=> $title]);
   }

}