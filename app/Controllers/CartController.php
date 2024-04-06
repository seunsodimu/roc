<?php
namespace App\Controllers;
use App\Models\ProductsModel;
use App\Models\PaymentsModel;

use CodeIgniter\Controller;

class CartController extends BaseController
{
    public $data = [
        'page_title' => ['title' => 'Cart'],
        'meta_tags' => [
            'tags'=>[
                [
                'enabled' => true,
                'description' => 'Cart',
                'content' => 'Cart',
                'robots' => 'noindex, nofollow',
                'type' => 'name',
                'type_value' => 'description',
            ]
            ]
        ],
        'page_top_promo' => ['enabled' => false],
        'active' => 'cart'
    ];
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        
        $data = []; 
        echo view('cart', ['data' => $this->data]);
    }

    public function add()
    {
        helper(['form', 'url']);

        $rules = [
            'product_name' => 'required',
            'product_id' => 'required',
            'product_price' => 'required',
            'product_sku' => 'required',
            'product_color_name' => 'required',
        ];

        if (!$this->validate($rules)) {
            $msgtype = "error";
            $msg = $this->validator->listErrors();
        } else {
            $subtotal = round(($this->request->getVar('rent_duration') * $this->request->getVar('product_price')), 2);
            $product = [
                'product_name' => $this->request->getVar('product_name'),
                'product_id' => $this->request->getVar('product_id'),
                'product_price' => $this->request->getVar('product_price'),
                'product_variant_id' => $this->request->getVar('product_variant_id'),
                'product_sku' => $this->request->getVar('product_sku'),
                'color_id' => $this->request->getVar('color_id'),
                'color_name' => $this->request->getVar('product_color_name'),
                'productQty' => $this->request->getVar('product_qty'),
                'product_image' => $this->request->getVar('product_image') ?? 'no-image.jpg',
                'rental_start' => $this->request->getVar('rent_start_date') ?? '',
                'rent_duration' => $this->request->getVar('rent_duration') ?? '',
                'product_extra' => $this->request->getVar('product_extra') ?? '',
                'subtotal' => $subtotal
            ];

            $cart = session()->get('cart') ?? [];
            $cart[] = $product;
            session()->set('cart', $cart);
            $cart_count = session()->get('cart_count') ?? 0;
            session()->set('cart_count', $cart_count + 1);
            session()->set('cart_total', $this->cartTotal());
            $msgtype = "success";
            $msg = "Product added to cart";
        }
            return json_encode(['msgtype' => $msgtype, 'msg' => $msg]);
        
    }

    public function cartTotal()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'] * $item['productQty'];
        }
        return $total;
    }

    public function update()
    {
        $data = [];
        echo view('cart', ['data' => $data]);
    }

    public function remove()
    {
        //remove item from cart session by key
        $key = $this->request->getVar('key');
        $cart = session()->get('cart');
        unset($cart[$key]);
        if(count($cart) == 0) {
            session()->remove('cart');
            session()->remove('cart_count');
            session()->remove('cart_total');
            return json_encode(['msgtype' => 'success', 'msg' => 'Cart is empty']);
        }
        session()->set('cart', $cart);
        session()->set('cart_count', session()->get('cart_count') - 1);
        session()->set('cart_total', $this->cartTotal());        
        return json_encode(['msgtype' => 'success', 'msg' => 'Product removed from cart']);
    }

    public function checkout()
    {
        $data = [];
        echo view('checkout', ['data' => $data]);
    }

    public function processPayment()
    {
        $data = [];
        echo view('checkout', ['data' => $data]);
    }

    public function orderConfirmation()
    {
        $data = [];
        echo view('order-confirmation', ['data' => $data]);
    }

    public function saveCart()
    {
        $paymentsModel = new PaymentsModel();
        $cart = session()->get('cart');
        $cartData = [
            'user_id' => session()->get('user_id'),
            'cart' => json_encode($cart),
            'cart_total' => session()->get('cart_total'),
            'cart_count' => session()->get('cart_count')
        ];
        $paymentsModel->saveCart($cartData);
        //$this->clearCartSession();
        return json_encode(['msgtype' => 'success', 'msg' => 'Cart saved successfully']);
    }

    public function getSavedCarts()
    {
        $paymentsModel = new PaymentsModel();
        $savedCarts = $paymentsModel->getSavedCarts(session()->get('user_id'));
        return json_encode($savedCarts);
    }

    public function getSavedCart()
    {
        $id = $this->request->getVar('id');
        $user_id = session()->get('user_id');
        $paymentsModel = new PaymentsModel();
        $savedCart = $paymentsModel->getSavedCartById($id, $user_id);
        return json_encode($savedCart);
    }

    public function deleteSavedCart()
    {
        $id = $this->request->getVar('cart_id');
        $paymentsModel = new PaymentsModel();
        $user_id = session()->get('user_id');
        $paymentsModel->deleteSavedCart($id, $user_id);
        return json_encode(['status' => 'success', 'msg' => 'Cart deleted successfully']);
    }

    public function updateSavedCart()
    {
        $id = $this->request->getVar('id');
        $user_id = session()->get('user_id');
        $data = [
            'cart_total' => $this->request->getVar('cart_total'),
            'cart_count' => $this->request->getVar('cart_count'),
            'cart' => $this->request->getVar('cart')
        ];
        $paymentsModel = new PaymentsModel();
        $paymentsModel->updateSavedCart($id, $user_id, $data);
        return json_encode(['status' => 'success', 'msg' => 'Cart updated successfully']);
    }

    public function loadSavedCart()
    {
        $id = $this->request->getVar('id');
        $paymentsModel = new PaymentsModel();
        $user_id = session()->get('user_id');
        $savedCart = $paymentsModel->getSavedCartById($id, $user_id);
        session()->set('cart', json_decode($savedCart['cart'], true));
        session()->set('cart_count', $savedCart['cart_count']);
        session()->set('cart_total', $savedCart['cart_total']);
        return json_encode(['status' => true, 'msg' => 'Cart loaded successfully']);
    }

    public function clearCartSession()
    {
        session()->remove('cart');
        session()->remove('cart_count');
        session()->remove('cart_total');
        return true;
    }
}