<?php

namespace App\Controllers;

use Predis\Client as Redis;
use App\Models\PagesModel;

class Pages extends BaseController
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
            'cta4' => $this->findSection($homeData['data'], 'cta4')
        ];
        // var_dump($data['testimonials']['reviews']); exit;
        return view('home', ['data' => $data]);
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


    public function page($pageName)
    {
        $pagesModel = new PagesModel();
        $pageData = $pagesModel->retrievePageData($pageName);
        //$pageData = json_decode($pageData['data'], true);
        
        $data = [
            'page_title' => $this->findSection($pageData['data'], 'page_title'),
            'meta_tags' => $this->findSection($pageData['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($pageData['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($pageData['data'], 'page_top_promo'),
            'banner' => $this->findSection($pageData['data'], 'banner'),
            'page_body' => $this->findSection($pageData['data'], 'page-body'),
            'product_carousel' => $this->findSection($pageData['data'], 'product-carousel'),
            'active' => $pageName
        ];
        switch ($pageName) {
            case 'contact':
                $data['contact_form'] = $this->findSection($pageData['data'], 'contact-form');
                $data['videos']['enabled'] = false;
                break;
            case 'videos':
                $data['videos'] = $this->findSection($pageData['data'], 'videos');
                $data['contact_form']['enabled'] = false;
                break;
            case 'about':
                $data['contact_form']['enabled'] = false;
                $data['videos']['enabled'] = false;
                break;
                case 'terms':
                    $data['contact_form']['enabled'] = false;
                    $data['videos']['enabled'] = false;
                    break;
                    case 'privacy':
                        $data['contact_form']['enabled'] = false;
                        $data['videos']['enabled'] = false;
                        break;
        }
      //  var_dump($this->findSection($pageData['data'], 'page-body')); exit;
        return view('text-pages', ['data' => $data]);
    }


}