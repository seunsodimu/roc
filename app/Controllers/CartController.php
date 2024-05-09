<?php
namespace App\Controllers;
use App\Models\ProductsModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Models\ShippingModel;
use App\Models\ProductModel;

use App\Controllers\ShippingController;
use App\Libraries\FedExLib\FedExAPI;

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

    public function checkout2()
    {
        $product = new ProductModel();
        $user = new UserModel();
        $shipper = new ShippingModel();
        $payments = new PaymentsModel();
        $shipping = new ShippingController();
            $this->data['page_title']['title'] = 'Checkout';
            $this->data['page_top_promo']['enabled'] = false;
            $this->data['active'] = 'checkout';
            $this->data['user_data'] = $user->getUser(session()->get('user_id')); //var_dump($this->data['user_data']); exit;
            if (session()->get('cart') == null) {
                return redirect()->to('/cart');
            }
            $fromAddress = [
                "name" => "ROC Outdoors",
                "street1" => "1233 Automobile Blv",
                "city" => "Clearwater",
                "stateOrProvinceCode" => "FL",
                "zip" => "33762"
            ];
    
            $toAddress = [
                "name" => $this->data['user_data']['first_name'].' '.$this->data['user_data']['last_name'],
                "street1" => $this->data['user_data']['address'],
                "city" => $this->data['user_data']['city'],
                "state" => $this->data['user_data']['state'],
                "zip" => $this->data['user_data']['zip'],
                "phone" => $this->data['user_data']['phone'],
                "email" => $this->data['user_data']['email']
            ];
    
            $cart = session()->get('cart');
            if(session()->get('cart_count') > 1) {
                //multiple parcels for multiple items in cart
            $parcels = [];
            foreach ($cart as $item) {
                $ship_item = $product->where('id', $item['product_id'])->first();
                $parcel = [
                    "parcel" => [
                    "length" => $ship_item['length'],
                    "width" => $ship_item['breadth'],
                    "height" => $ship_item['height'],
                    "weight" => $ship_item['weight']
                ]];
                array_push($parcels, $parcel);
            }
            $params = [
                'fromAddress' => $fromAddress,
                'toAddress' => $toAddress,
                'parcels' => $parcels
            ];
            $getshipment = $shipping->getRatesWithCaching($params, 'multi'); 
            $shipment = json_decode($getshipment);
            $shipment = $shipment->rates;
            //$shipment = $shipping->getOrderRates($fromAddress, $toAddress, $parcels);
            } else {
                //single parcel for single item in cart
                $ship_item = $product->where('id', $cart[0]['product_id'])->first();
                $parcel = [
                    "length" => $ship_item['length'],
                    "width" => $ship_item['breadth'],
                    "height" => $ship_item['height'],
                    "weight" => $ship_item['weight']
                ];
                $params = [
                    'fromAddress' => $fromAddress,
                    'toAddress' => $toAddress,
                    'parcels' => $parcel
                ];
                $shipment = $shipping->getRatesWithCaching($params, 'single');
                // $shipment = $shipping->getStatelessRates($fromAddress, $toAddress, $parcel);
            }
            $shipping_options = $shipper->where('status', 1)->findAll();
    
            $rates = [];
            foreach ($shipment as $rate) {
                //if service is name in $shipping add to array
                foreach ($shipping_options as $ship) {
                    if ($rate->service == $ship['name']) {
                        $rates[] = [
                            'service' => $rate->service,
                            'rate' => $rate->rate,
                            'delivery_days' => $rate->delivery_days,
                            'carrier' => $rate->carrier,
                            'service_identifier' => $ship['shipper'].'_'.$ship['name']
                        ];
                    }
                }
            }
            $this->data['shipping_rates'] = $rates;
            $this->data['selected_shipping'] = session()->get('selected_shipping') ?? 'Pickup';
            $this->data['selected_shipping_cost'] = session()->get('selected_shipping_cost') ?? 0;
            $this->data['cart_total'] = session()->get('cart_total');
            if($payments->isTaxEnabled()){
            $tax = $payments->getTaxRate($this->data['user_data']['zip'], $this->data['user_data']['state']); 
            $this->data['tax_rate'] = $tax['estimated_combined_rate'];
            $taxRate = session()->get('taxes') ?? ($this->data['cart_total'] + $this->data['selected_shipping_cost']) * $this->data['tax_rate'];
            $this->data['taxes'] = round($taxRate, 2);
            $grand_total = session()->get('grand_total') ?? session()->get('cart_total') + $this->data['selected_shipping_cost'] + $this->data['taxes'];
            $this->data['grand_total'] = round($grand_total, 2);
            }else{
                $this->data['tax_rate'] = 0;
                $this->data['taxes'] = 0;
                $this->data['grand_total'] = session()->get('grand_total') ?? round(session()->get('cart_total') + $this->data['selected_shipping_cost'], 2);
            }
            session()->set('grand_total', $this->data['grand_total']);
            session()->set('taxes', $this->data['taxes']);
            // var_dump($this->data['meta_tags']); die();
            return view('checkout', ['data' => $this->data]);
    }

    public function updateShippingOption()
    {
        $shipping = $this->request->getVar('shipping_option');
        $shipping_cost = $this->request->getVar('shipping_cost');
        $shipping_cost = str_replace('$', '', $shipping_cost);
        $tax_rate = $this->request->getVar('tax_rate');
        $taxes = (session()->get('cart_total') + $shipping_cost) * $tax_rate;
        session()->set('selected_shipping', $shipping);
        session()->set('selected_shipping_cost', $shipping_cost);
        session()->set('taxes', $taxes);
        $grand_total = session()->get('cart_total') + $shipping_cost + $taxes;
        session()->set('grand_total', $grand_total);
        return json_encode(['status' => 'success', 'msg' => 'Shipping option updated successfully']);
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

    public function checkout()
    {
        $product = new ProductModel();
        $user = new UserModel();
        $shipper = new ShippingModel();
        $payments = new PaymentsModel();
        $shipping = new ShippingController();
            $this->data['page_title']['title'] = 'Checkout';
            $this->data['page_top_promo']['enabled'] = false;
            $this->data['active'] = 'checkout';
            $this->data['user_data'] = $user->getUser(session()->get('user_id')); //var_dump($this->data['user_data']); exit;
            if (session()->get('cart') == null) {
                return redirect()->to('/cart');
            }
            $sender = [
                "stateOrProvinceCode" => "FL",
                "postalCode" => "33762",
                "countryCode" => "US"
            ];

            $recipient = [
                "stateOrProvinceCode" => $this->data['user_data']['state'],
                "postalCode" => $this->data['user_data']['zip'],
                "countryCode" => "US"
            ];
    
            $toAddress = [
                "name" => $this->data['user_data']['first_name'].' '.$this->data['user_data']['last_name'],
                "street1" => $this->data['user_data']['address'],
                "city" => $this->data['user_data']['city'],
                "state" => $this->data['user_data']['state'],
                "zip" => $this->data['user_data']['zip'],
                "phone" => $this->data['user_data']['phone'],
                "email" => $this->data['user_data']['email']
            ];
    
            $cart = session()->get('cart');
            $packagesx = [];
            foreach ($cart as $item) {
                $ship_item = $product->where('id', $item['product_id'])->first();
            $package = [
                "weight" =>[
                    "value" => intval($ship_item['weight']),
                    "units" => "LB"
                ],
                "dimensions" => [
                    "length" => intval($ship_item['length']),
                    "width" => intval($ship_item['breadth']),
                    "height" => intval($ship_item['height']),
                    "units" => "IN"
                ]
                ];
                array_push($packagesx, $package);
            }
            $sender = [
                "stateOrProvinceCode" => "FL",
                "postalCode" => "33762",
                "countryCode" => "US"
            ];
            // $recipient = [
            //     "postalCode"    => "76052",
            //     "stateOrProvinceCode" => "TX",
            //     "countryCode"   => "US"
            // ];
            //multiple parcels for multiple items in cart
            // $parcels = [];
            $packages = [
                "weight" =>[
                    "value" => 1,
                    "units" => "LB"
                ],
                "dimensions" => [
                    "length" => 12,
                    "width" => 12,
                    "height" => 12,
                    "units" => "IN"
                ],
            ];

            // var_dump($packagesx); echo '<br>';
            // var_dump($packages);
            // die();
            $shipping = new FedExAPI();
            $shipment = $shipping->getQuickRates($sender, $recipient, $packagesx);
            $shipping_options = $shipper->where('status', 1)->findAll();
    // var_dump($shipment); die();
            $rates = [];
            foreach ($shipment as $rate) {
                //if service is name in $shipping add to array
                foreach ($shipping_options as $ship) {
                    if ($rate['serviceType'] == $ship['name']) {
                        //delivery days is no of days between date('Y-m-d') and $rate['deliveryDate']
                        $delivery_days = date_diff(date_create(date('Y-m-d')), date_create($rate['deliveryDate']))->format('%a');
                        $rates[] = [
                            'service' => $rate['service'],
                            'rate' => $rate['amount'],
                            'delivery_days' => $delivery_days,
                            'carrier' => $ship['shipper'],
                            'service_identifier' => $ship['shipper'].'_'.$ship['name']
                        ];
                    }
                }
            }
            $this->data['shipping_rates'] = $rates;
            $this->data['selected_shipping'] = session()->get('selected_shipping') ?? 'Pickup';
            $this->data['selected_shipping_cost'] = session()->get('selected_shipping_cost') ?? 0;
            $this->data['cart_total'] = session()->get('cart_total');
            if($payments->isTaxEnabled()){
            $tax = $payments->getTaxRate($this->data['user_data']['zip'], $this->data['user_data']['state']); 
            $this->data['tax_rate'] = $tax['estimated_combined_rate'];
            $taxRate = session()->get('taxes') ?? ($this->data['cart_total'] + $this->data['selected_shipping_cost']) * $this->data['tax_rate'];
            $this->data['taxes'] = round($taxRate, 2);
            $grand_total = session()->get('grand_total') ?? session()->get('cart_total') + $this->data['selected_shipping_cost'] + $this->data['taxes'];
            $this->data['grand_total'] = round($grand_total, 2);
            }else{
                $this->data['tax_rate'] = 0;
                $this->data['taxes'] = 0;
                $this->data['grand_total'] = session()->get('grand_total') ?? round(session()->get('cart_total') + $this->data['selected_shipping_cost'], 2);
            }
            session()->set('grand_total', $this->data['grand_total']);
            session()->set('taxes', $this->data['taxes']);
            // var_dump($this->data['meta_tags']); die();
            return view('checkout', ['data' => $this->data]);
    }

    public function clearCartSession()
    {
        session()->remove('cart');
        session()->remove('cart_count');
        session()->remove('cart_total');
        return true;
    }
}