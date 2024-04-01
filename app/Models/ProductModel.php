<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model {
    protected $table = 'products';
    protected $allowedFields = ['collection_id', 'name', 'description', 'sku', 'availability', 'length', 'breadth', 'height', 'weight', 'material', 'sales_price', 'included_items'];
    
    public function getProducts() {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('status', 'ready');
        $builder->select('products.*, collections.name as collection_name, collections.slug as collection_slug');
        $builder->join('collections', 'collections.id = products.collection_id', 'left');
        // $builder->orderBy('products.name', 'desc');
        return $builder->get()->getResultArray();
    }

    public function getProductById($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('products.status', 'ready');
        $builder->where('products.id', $id);
        $builder->select('products.*, collections.name as collection_name, collections.slug as collection_slug');
        $builder->join('collections', 'collections.id = products.collection_id', 'left');
        return $builder->get()->getRowArray();
    }

    public function getProductBySlug($slug) {
        //get product by slug with collection name
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('products.status', 'ready');
        $builder->where('products.slug', $slug);
        $builder->select('products.*, collections.name as collection_name, collections.slug as collection_slug');
        $builder->join('collections', 'collections.id = products.collection_id', 'left');
        return $builder->get()->getRowArray();
    }

    public function getProductImages($productId) {
        $db = \Config\Database::connect();
        $builder = $db->table('product_images');
        $builder->where('product_id', $productId);
        return $builder->get()->getResultArray();
    }

    public function getSimilarProducts($productId, $collectionId) {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('collection_id', $collectionId);
        $builder->where('id !=', $productId);
        $builder->where('status', 'ready');
        return $builder->get()->getResultArray();
    }

    public function getRelatedProducts($productId) {
        $db = \Config\Database::connect();
        $builder = $db->table('related_products');
        $builder->where('related_products.product_id', $productId);
        $builder->select('related_products.related_product_id, products.name, products.slug, products.display_image');
        $builder->join('products', 'products.id = related_products.related_product_id', 'left');
        return $builder->get()->getResultArray();
    }

    public function getProductColorVariants($productId) {
        $db = \Config\Database::connect();
        $builder = $db->table('variants');
        $builder->where('product_id', $productId);
        $builder->where('variant_type', 'color');
        return $builder->get()->getResultArray();
    }

    public function getProductVariants($productId) {
        $db = \Config\Database::connect();
        $builder = $db->table('variants');
        $builder->where('product_id', $productId);
        return $builder->get()->getResultArray();
    }

    public function getColorsByVariantId($variantId) {
        $db = \Config\Database::connect();
        $builder = $db->table('variant_colors');
        $builder->where('variant_id', $variantId);
        $builder->groupBy('color');
        return $builder->get()->getResultArray();
    }

    public function getVariantColorImagesByProductId($productId) {
        $db = \Config\Database::connect();
        $builder = $db->table('variant_colors');
        $builder->select('image');
        $builder->where('product_id', $productId);
        $builder->groupBy('color');
        return $builder->get()->getResultArray();
    }
    public function getVariantColorsByProductId($productId) {
        $db = \Config\Database::connect();
        $builder = $db->table('variant_colors');
        $builder->select('*');
        $builder->where('product_id', $productId);
        $builder->groupBy('color');
        return $builder->get()->getResultArray();
    }

    public function getVariantColorById($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('variant_colors');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    
    public function searchProducts($keyword) {
        //search products by name or description, return all products that match along with collection name
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('products.status', 'ready');
        $builder->select('products.*, collections.name as collection_name, collections.slug as collection_slug');
        $builder->join('collections', 'collections.id = products.collection_id', 'left');
        $builder->like('products.name', $keyword)->orLike('products.description', $keyword);
        return $builder->get()->getResultArray();
    }
    
    public function getProductsByCategory($categorySlug) {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('status', 'ready');
        $builder->where('collections.slug', $categorySlug);
        $builder->select('products.*, collections.name as collection_name, collections.slug as collection_slug');
        $builder->join('collections', 'collections.id = products.collection_id', 'left');
        // $builder->orderBy('products.name', 'desc');
        return $builder->get()->getResultArray();
    }

    //get collection with product count
    public function getCollections() {
        $db = \Config\Database::connect();
        $builder = $db->table('collections');
        $builder->select('collections.*, COUNT(products.id) as product_count');
        $builder->join('products', 'products.collection_id = collections.id', 'left');
        $builder->groupBy('collections.id');
        return $builder->get()->getResultArray();
    }

    public function getCollectionBySlug($slug) {
        $db = \Config\Database::connect();
        $builder = $db->table('collections');
        $builder->where('slug', $slug);
        return $builder->get()->getRowArray();
    }

}
