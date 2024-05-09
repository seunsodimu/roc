<?php

namespace App\Controllers;
// require easypost-php library from composer
require_once APPPATH . '../vendor/autoload.php';

use EasyPost\EasyPost;
use EasyPost\Shipment;
use EasyPost\Webhook;
use App\Models\ShippingModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use Predis\Client as Redis;

class ShippingController extends BaseController
{
    private $client;
    private $redis;
    public function __construct()
    {
        $this->client = new \EasyPost\EasyPostClient(getenv('EASYPOST_API_KEY'));
        $this->redis = new Redis([
            'scheme' => 'tcp',
            'host'   => 'localhost',
            'port'   => 6379,
        ]);
    }

    public function getRatesWithCaching($params, $type)
    {
        $paramsKeySingle = 'rates_params';
        $responseKeySingle = 'rates_response';
        $paramsKeyMulti = 'rates_params_multi';
        $responseKeyMulti = 'rates_response_multi';

        $paramsKey = $type == 'multi' ? $paramsKeyMulti : $paramsKeySingle;
        $responseKey = $type == 'multi' ? $responseKeyMulti : $responseKeySingle;

        $cachedParams = $this->redis->get($paramsKey);
        $cachedResponse = $this->redis->get($responseKey);
        // var_dump($params['fromAddress']); die;

        if ($cachedParams && $cachedResponse && $cachedParams === json_encode($params)) {
            // If the parameters are the same as last time, return the cached response
            // var_dump($cachedResponse); die;
            return $cachedResponse;
        }

        if ($type == 'multi') {
            $response = $this->getOrderRates($params['fromAddress'], $params['toAddress'], $params['parcels']);
            $this->redis->set($paramsKey, json_encode($params));
            $this->redis->set($responseKey, json_encode($response));
        } else {
            $response = $this->getStatelessRates($params['fromAddress'], $params['toAddress'], $params['parcels']);
            $this->redis->set($paramsKey, json_encode($params));
            $this->redis->set($responseKey, json_encode($response));
        }
        // $response = json_encode($response);
        //   var_dump($response[0]->service); die;
        return $response;
    }

    public function getRates($fromAddress, $toAddress, $parcel)
    {
        $shipment = $this->client->shipment->create([
            "from_address" => $fromAddress, 
            "to_address" => $toAddress, 
            "parcel" => $parcel,
            "options" => [
                "carrier_accounts" => ["ca_f10d3218de8244da8aacd1b9e40c0ba7"],
                "service" => "EconomySelect",
            ]
        ]);
        return $shipment->rates;
    }
    public function getStatelessRates($fromAddress, $toAddress, $parcel)
    {
        $shipment = $this->client->betaRate->retrieveStatelessRates([
            "from_address" => $fromAddress, 
            "to_address" => $toAddress, 
            "parcel" => $parcel,
            "options" => [
                "carrier_accounts" => ["ca_f10d3218de8244da8aacd1b9e40c0ba7"],
                "service" => "EconomySelect",
            ]
        ]);
        return $shipment;
    }

    public function getOrderRates($fromAddress, $toAddress, $parcel)
    {
        $shipment = $this->client->order->create([
            "from_address" => $fromAddress, 
            "to_address" => $toAddress, 
            "shipments" => $parcel,
            "options" => [
                "carrier_accounts" => ["ca_b26fa365f5d44c69b770995819eca8de"]
            ]
        ]);
        return $shipment;
    }

    public function createLabel($shipmentId)
    {
        $shipment = $this->client->shipment->retrieve($shipmentId);
        $shipment->buy($shipment->lowest_rate());

        return $shipment->postage_label->label_url;
    }

    public function checkStatus($shipmentId)
    {
        $shipment = $this->client->shipment->retrieve($shipmentId);

        return $shipment->tracking_code;
    }

    public function webhookListener()
    {
        $payload = file_get_contents('php://input');
        $webhook = $$this->client->shipment->webhook->constructFrom($payload, null, true);

        // Handle the webhook event (e.g., update shipment status in your database)
    }

    public function myRates()
    {
        if (session()->get('cart') == null) {
            return redirect()->to('/cart');
        }
        $fromAddress = [
            "name" => "ROC Outdoors",
            "street1" => "1233 Automobile Blv",
            "city" => "Clearwater",
            "state" => "FL",
            "zip" => "33762"
        ];

        $user = new UserModel();
        $user_details = $user->getUser(session()->get('user_id'));

        $toAddress = [
            "name" => $user_details['first_name'].' '.$user_details['last_name'],
            "street1" => $user_details['address'],
            "city" => $user_details['city'],
            "state" => $user_details['state'],
            "zip" => $user_details['zip'],
            "phone" => $user_details['phone'],
            "email" => $user_details['email']
        ];

        $cart = session()->get('cart');
        $product = new ProductModel();
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

        $shipment = $this->getOrderRates($fromAddress, $toAddress, $parcels);
        } else {
            //single parcel for single item in cart
            $ship_item = $product->where('id', $cart[0]['product_id'])->first();
            $parcel = [
                "length" => $ship_item['length'],
                "width" => $ship_item['breadth'],
                "height" => $ship_item['height'],
                "weight" => $ship_item['weight']
            ];

            $shipment = $this->getStatelessRates($fromAddress, $toAddress, $parcel);
        }
        $shipper = new ShippingModel();
        $shipping = $shipper->where('status', 1)->findAll();

        $rates = [];
        foreach ($shipment->rates as $rate) {
            //if service is name in $shipping add to array
            foreach ($shipping as $ship) {
                if ($rate->service == $ship['name']) {
                    $rates[] = [
                        'service' => $rate->service,
                        'rate' => $rate->rate,
                        'delivery_days' => $rate->delivery_days,
                        'carrier' => $rate->carrier
                    ];
                }
            }
        }
        $response = [
            'status' => 'success',
            'data' => $rates,
            'taxes' => '0.65',
        ];
        return $this->response->setJSON($response);
    }

    public function testOrderRate()
    { 
        //clear cookies $this->redis->get($paramsKey);
        // $this->redis->del('rates_params');
        // $this->redis->del('rates_response');
        
        $fromAddress = [
            "name" => "ROC Outdoors",
            "street1" => "1233 Automobile Blv",
            "city" => "Clearwater",
            "state" => "FL",
            "zip" => "33762"
        ];

        $user = new UserModel();
        $user_details = $user->getUser(session()->get('user_id'));

        $toAddress = [
            "name" => $user_details['first_name'].' '.$user_details['last_name'],
            "street1" => $user_details['address'],
            "city" => $user_details['city'],
            "state" => $user_details['state'],
            "zip" => $user_details['zip'],
            "phone" => $user_details['phone'],
            "email" => $user_details['email']
        ];

        //multiple parcels
        // $parcel1 = [
        //     "parcel" => [
        //     "length" => 12.00,
        //     "width" => 12.00,
        //     "height" => 12.00,
        //     "weight" => 10.69
        // ]];

        // $parcel2 = [
        //     "parcel" => [
        //     "length" => 12.67,
        //     "width" => 12.98,
        //     "height" => 12.99,
        //     "weight" => 10.00
        // ]];

        // $parcels = [$parcel1, $parcel2];
        $cart = session()->get('cart');
        $product = new ProductModel();
            //multiple parcels (for multiple items in cart
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

        $shipment = $this->getOrderRates($fromAddress, $toAddress, $parcels);
        $ship_ = json_encode($shipment);
        // var_dump($shipment);
        foreach ($shipment->rates as $rate) {
            echo 'Carrier: ' . $rate->carrier;
            echo  '<br>Service: ' . $rate->service;
            echo '<br>Rate: ' . $rate->rate;
            echo '<br>Deliver: '.$rate->delivery_days . '<br>';
            // var_dump($rate);
            echo '<hr><br>';
        }   
    }
}