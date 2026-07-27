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
                'amount_cents' => (int) round($order->total * 100),
                'currency' => 'EGP',
                'merchant_order_id' => $order->order_number,
                'items' => [],
            ]
        );

        $response->throw();

        return $response->json('id');
    }
}
