<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymobService
{
    protected string $apiKey;
    protected int $integrationId;
    protected int $iframeId;

    public function __construct()
    {
        $this->apiKey = config('paymob.api_key');
        $this->integrationId = config('paymob.integration_id');
        $this->iframeId = config('paymob.iframe_id');
    }

    public function authenticate()
    {
        $response = Http::post(
            'https://accept.paymob.com/api/auth/tokens',
            [
                'api_key' => $this->apiKey,
            ]
        );

        return $response->json('token');
    }

    public function createOrder(Order $order)
    {
        $token = $this->authenticate();

        $response = Http::post(
            'https://accept.paymob.com/api/ecommerce/orders',
            [
                'auth_token' => $token,
                'delivery_needed' => false,
                'amount_cents' => (int) round($order->total * 100), // paymob بتقبل قيمة المبلغ بالقروش 
                'currency' => 'EGP',
                'merchant_order_id' => $order->order_number,
                'items' => [],
            ]
        );

        $response->throw();

        return $response->json('id');
    }

    public function getPaymentKey(Order $order)
    {
        $token = $this->authenticate();

        $response = Http::post(
            'https://accept.paymob.com/api/acceptance/payment_keys',
            [
                'auth_token' => $token,

                'amount_cents' => (int) round($order->total * 100),

                'expiration' => 3600,

                'order_id' => $order->paymob_order_id,

                'billing_data' => [
                    'first_name' => $order->name,
                    'last_name' => '.',
                    'email' => $order->email,
                    'phone_number' => $order->phone,

                    'apartment' => 'NA',
                    'floor' => 'NA',
                    'street' => $order->address,
                    'building' => 'NA',
                    'shipping_method' => 'NA',
                    'postal_code' => 'NA',
                    'city' => $order->city,
                    'country' => 'EG',
                    'state' => $order->governorate,
                ],

                'currency' => 'EGP',

                'integration_id' => config('paymob.integration_id'),
            ]
        );

        return $response->json('token');
    }

    public function getIframeUrl(string $paymentKey)
    {
        // \Log::emergency('PAYMOB WEBHOOK', array($paymentKey));

        return "https://accept.paymob.com/api/acceptance/iframes/" . config('paymob.iframe_id') . "?payment_token=" . $paymentKey;
    }
}