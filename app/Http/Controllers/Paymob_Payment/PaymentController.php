<?php

namespace App\Http\Controllers\Paymob_Payment;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function success(CartService $cartService)
    {

        $cartService->clear();

        return redirect('https://dcc5-156-215-74-151.ngrok-free.app')
            ->with(
                'success',
                'Payment completed successfully. Thank you for shopping with us ♥'
            );

        // return redirect()
        //     ->route('home')
        //     ->with(
        //         'success',
        //         'Payment completed successfully. Thank you for shopping with us ♥'
        //     );
    }
}