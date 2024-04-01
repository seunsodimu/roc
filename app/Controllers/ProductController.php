<?php namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PagesModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response\JSON;

class ProductController extends Controller {

    public function __construct() {
        
    }
    public function index() {
        $model = new ProductModel();
        $pagesModel = new PagesModel();
        $sections = $pagesModel->retrievePageData('products');
        $data = [
            'page_title' => $this->findSection($sections['data'], 'page_title'),
            'meta_tags' => $this->findSection($sections['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($sections['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($sections['data'], 'page_top_promo'),
            'banner' => $this->findSection($sections['data'], 'banner'),
            'page_body' => $this->findSection($sections['data'], 'page_body'),
            'products' => $model->getProducts(),
            'collections' => $model->getCollections(),
            'active' => 'products'
        ];
        
        echo view('products', ['data' => $data]);
    }

    public function view($slug) {
        $model = new ProductModel();
        $pagesModel = new PagesModel();
        $sections = $pagesModel->retrievePageData('products');
        // if $slug is integer, use getProductById else getProductBySlug
        $product = is_numeric($slug) ? $model->getProductById($slug) : $model->getProductBySlug($slug);
        // if product is not found, redirect to page not found
        if(!$product) {
            return redirect()->to(base_url('pagenotfound'));
        }
        $images = $model->getProductImages($product['id']);
        if(count($images) == 0) {
            $images = $model->getVariantColorImagesByProductId($product['id']);
        }
        $variantcolors = $model->getVariantColorsByProductId($product['id']);
        $data = [
            'page_title' => ['title' => $product['name']],
            'meta_tags' => $this->findSection($sections['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($sections['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($sections['data'], 'page_top_promo'),
            'banner' => $this->findSection($sections['data'], 'banner'),
            'page_body' => $this->findSection($sections['data'], 'page_body'),
            'product' => $product,
            'images' => $images,
            'variants' => $model->getProductVariants($product['id']),
            'variantcolors' => $variantcolors,
            'similar_products' => $model->getSimilarProducts($product['id'], $product['collection_id']),
            'related_products' => $model->getRelatedProducts($product['id']),
            'active' => 'products'
        ];
        
        echo view('product', ['data' => $data]);
    }

    public function viewId($id){
        $model = new ProductModel();
        $product = $model->getProductById($id);
        return redirect()->to(base_url('product/'.$product['slug']));
    }

    public function colorVariants()
    {
        $variantId = $this->request->getVar('variant_id');
        $model = new ProductModel();
        $colors = $model->getColorsByVariantId($variantId);
        return json_encode($colors);

    }

    public function colorVariant()
    {
        $id = $this->request->getVar('id');
        $model = new ProductModel();
        $vc = $model->getVariantColorById($id); 
        return json_encode($vc);
    }

    public function search() {
        $model = new ProductModel();
        $pagesModel = new PagesModel();
        $keyword = $this->request->getVar('q');
        $sections = $pagesModel->retrievePageData('products');
        $products = $model->searchProducts($keyword);
        $data = [
            'page_title' => ['title' => 'Search Results for "<i>'.$keyword.'</i>"'],
            'meta_tags' => $this->findSection($sections['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($sections['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($sections['data'], 'page_top_promo'),
            'banner' => $this->findSection($sections['data'], 'banner'),
            'page_body' => count($products) > 0 ? ['text' => count($products).' results found for "<i>'.$keyword.'</i>"'] : ['text' => 'No results found for "<i>'.$keyword.'</i>"' ],
            'products' => $products,
            'collections' => $model->getCollections(),
            'active' => 'products'
        ];
        echo view('search', ['data' => $data]);
    }

    public function category($categorySlug) {
        $model = new ProductModel();
        $pagesModel = new PagesModel();
        $sections = $pagesModel->retrievePageData('products');
        $collection = $model->getCollectionBySlug($categorySlug);
        $data = [
            'page_title' => ['title' => $collection['name']],
            'meta_tags' => $this->findSection($sections['data'], 'meta_tags'),
            'promo_popup' => $this->findSection($sections['data'], 'promo_popup'),
            'page_top_promo' => $this->findSection($sections['data'], 'page_top_promo'),
            'banner' => $this->findSection($sections['data'], 'banner'),
            'page_body' => ['text' => $collection['description']],
            'products' => $model->getProductsByCategory($categorySlug),
            'collections' => $model->getCollections(),
            'active' => 'products'
        ];
        
        echo view('products', ['data' => $data]);
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
