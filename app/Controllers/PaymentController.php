<?php namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PagesModel;
use App\Models\PaymentsModel;
use App\Models\RentalsModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response\JSON;
use PHPShopify\ShopifySDK;

class PaymentController extends Controller {

    public $data = [
        'page_title' => ['title' => 'Cart'],
        'meta_tags' => [
            'tags'=>[
                [
                'enabled' => true,
                'description' => 'Payment Page',
                'content' => 'Payment Page',
                'robots' => 'noindex, nofollow',
                'type' => 'name',
                'type_value' => 'description',
            ]
            ]
        ],
        'page_top_promo' => ['enabled' => false],
        'active' => 'cart'
    ];
    private $shopify;
    public function __construct() {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_API_KEY'));

        $config = array(
            "ShopUrl" => getenv('SHOPIFY_SHOP_URL'),
            "ApiKey" => getenv('SHOPIFY_API_KEY'),
            "Password" => getenv('SHOPIFY_API_PASSWORD')
        );

        $this->shopify = ShopifySDK::config($config);
    }
    public function index() 
    {
            $this->data['page_title']['title'] = 'Payment Success';
            $success_message = "<span class='text-color-primary me-1'><i class='fas fa-check'></i> Rad job, ".session()->get('firstname')."! Your payment cruised through successfully. Keep an eye on your inbox; we'll be sending you the lowdown on how to snag your rentals shortly</span>";
            session()->setFlashdata('msgtype', 'success');
            session()->setFlashdata('msg', $success_message);
            return view('payment-status', ['data' => $this->data]);
    }

    public function payment()
    {
        helper(['form', 'url']);

        // Get the cart from the session
        $cart = session()->get('cart');

        //get session id
        $session_id = session()->get('session_id');
        $success_url = urldecode(base_url('payment/success?session_id={CHECKOUT_SESSION_ID}'));
        $cancel_url = urldecode(base_url('payment/cancel?session_id={CHECKOUT_SESSION_ID}'));

        // Convert the cart items to Stripe line items
        $line_items = [];
        foreach ($cart as $item) {
           
            $product_name = str_replace("&apos;", "'", htmlspecialchars_decode($item['product_name'])). ' - ' . $item['color_name']. ' - ' . $item['product_extra']. ' - ' . $item['rent_duration']. ' days rental';
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product_name,
                    ],
                    'unit_amount' => $item['subtotal'] * 100, // Stripe expects the amount in cents
                ],
                'quantity' => 1,
            ];
        }

        //add shipping cost
        $line_items[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => str_replace("_", " ", session()->get('selected_shipping_option') ). ' Shipping Cost',
                ],
                'unit_amount' => session()->get('selected_shipping_cost') * 100, // Stripe expects the amount in cents
            ],
            'quantity' => 1,
        ];
        

        // Create the Stripe checkout session
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);
        
        // Redirect the user to the Stripe checkout
        return redirect()->to($checkout_session->url);
    }

    public function payment_success() {
        
        
        $stripe_session_id = $_REQUEST['session_id'];
        $session = \Stripe\Checkout\Session::retrieve($stripe_session_id);

        if($session->status=='complete') {
            $payment = new PaymentsModel();
            $rentals = new RentalsModel();
            $cart = session()->get('cart');
            $user_id = session()->get('user_id');
            $status = 'OrderProcessing';
            $rental_product_type = 'single_product';
            $updated_by = $user_id;
            
            $txn_data = [
                'user_id' => $user_id,
                'txn_id' => $stripe_session_id,
                'merchant' => 'stripe',
                'total_amount' => $session->amount_total / 100,
                'merch_info' => json_encode($session),
                'cart_info' => json_encode($cart),
                'status' => 'processed'
            ];
            $order_id = $payment->createTransaction($txn_data);

            foreach ($cart as $item) {
                $rent_start_date = date('Y-m-d', strtotime($item['rental_start']));
                $rent_end_date = date('Y-m-d', strtotime($item['rental_start']. ' + '.$item['rent_duration'].' days'));
                $data = [
                    'product_id' => $item['product_id'],
                    'rental_product_type' => $rental_product_type,
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'rent_start_date' => $rent_start_date,
                    'rent_end_date' => $rent_end_date,
                    'updated_by' => $updated_by,
                    'status' => $status,
                    'rental_detail' => $item['color_name'] . ' - ' . $item['product_extra'],
                ];
                $rentals->save($data);
            }
            session()->remove('cart');
            session()->remove('cart_count');
            session()->remove('cart_total');
            $this->data['page_title']['title'] = 'Payment Success';
            $this->data['order_data'] = $cart;
            $this->data['order_id'] = $order_id;
           
            $this->data['order_date'] = date('F j, Y');
            $this->data['order_email'] = session()->get('username');
            $this->data['order_total'] = $session->amount_total / 100;
            $success_message = "<span class='text-color-primary me-1'><i class='fas fa-check'></i> Rad job, ".session()->get('firstname')."! Your payment cruised through successfully. Keep an eye on your inbox; we'll be sending you the lowdown on how to snag your rentals shortly</span>";
            session()->setFlashdata('msgtype', 'success');
            session()->setFlashdata('msg', $success_message);
            return view('payment-status', ['data' => $this->data]);
        }else{
            $this->data['page_title']['title'] = 'Payment Failed';
            $error_message = "Bummer, ".session()->get('firstname')."! Your payment didn't catch the wave, so it wasn't successful. Try paddling in again with a different payment method, or reach out to our support crew at support@rocrentalsoutdoors.com or give us a shout at 727-201-2459. <br>Don't worry, we have kept your cart items safe for you.";
            session()->setFlashdata('msgtype', 'error');
            session()->setFlashdata('msg', $error_message);
            return view('payment-status', ['data' => $this->data]);
        }
    }

    public function payment_cancel() {
        $this->data['page_title']['title'] = 'Payment Cancelled';
        $error_message = "Uh oh, ".session()->get('firstname')."! You did not complete the payment process. If you need any help, please reach out to our support crew. You can save your cart items for later";
        session()->setFlashdata('msgtype', 'error');
        session()->setFlashdata('msg', $error_message);
        return view('payment-status', ['data' => $this->data]);
    }

    public function getTransaction()
    {
        $txn_id = $this->request->getVar('txn_id');
        $user_id = session()->get('user_id');
        $payment = new PaymentsModel();
        $txn = $payment->getTransactionById($txn_id, $user_id);
        return json_encode($txn);
    }

    public function createOrder($orderData)
    {
        try {
            $order = $this->shopify->Order->post($orderData);

            return $order;
        } catch (\Exception $e) {
            // Handle exception
        }
    }

    public function testShopify()
    {
        $orderData = [
            "line_items" => [
                [
                    "variant_id" => 447654529,
                    "quantity" => 1
                ]
            ],
            "customer" => [
                "first_name" => "John",
                "last_name" => "Doe",
                "email" => "john.doe@example.com"
            ],
            "billing_address" => [
                "first_name" => "John",
                "last_name" => "Doe",
                "address1" => "123 Amoebobacterieae St",
                "phone" => "555-555-5555",
                "city" => "Ottawa",
                "province" => "ON",
                "country" => "CA",
                "zip" => "K2P0V6"
            ],
            "shipping_address" => [
                "first_name" => "John",
                "last_name" => "Doe",
                "address1" => "123 Amoebobacterieae St",
                "phone" => "555-555-5555",
                "city" => "Ottawa",
                "province" => "ON",
                "country" => "CA",
                "zip" => "K2P0V6"
            ],
            "financial_status" => "paid",
            "total_tax" => "0.00",
            "total_price" => "199.99",
            "email" => "john.doe@example.com",
            "currency" => "USD"
        ];
    }

}