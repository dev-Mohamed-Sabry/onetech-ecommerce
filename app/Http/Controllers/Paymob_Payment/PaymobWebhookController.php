<?php

namespace App\Http\Controllers\Paymob_Payment;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymobWebhookController extends Controller
{
    public function handle(Request $request)
    {

        // \Log::info('PAYMOB WEBHOOK', [
        //     'all' => $request->all(),
        //     'content' => $request->getContent(),
        //     'headers' => $request->headers->all(),
        // ]);

        $data = $request->all();

        $transaction = $data['obj'] ?? null;

        if (!$transaction) {
            return response()->json([
                'success' => false
            ], 400);
        }

        $orderNumber = $transaction['order']['merchant_order_id'];

        $order = Order::where(
            'order_number',
            $orderNumber
        )->with('items.product')
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($transaction['success'] === true &&   $transaction['order']['payment_status'] === 'PAID' &&    $order->status === 'pending_payment') {

            DB::transaction(function () use ($order, $transaction) {

                // \Log::info('PAYMOB PAYMENT CONFIRMED', [
                //     'order_number' => $order->order_number,
                //     'transaction_id' => $transaction['id'],
                // ]);

                $order->decreaseStock();

                $order->update([
                    'status' => 'processing',
                    'paymob_order_id' => $transaction['order']['id'],
                    'transaction_id' => $transaction['id'],
                ]);
            });
        }

        return response()->json([
            'success' => true
        ]);
    }
}