<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->paginate(3);

        $totalOrders = $orders->total();

        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $processingOrders = Order::where('user_id', $user->id)->where('status', 'processing')->count();

        $deliveredOrders = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->count();

        $canceledOrders = Order::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->count();

        $paginatedOrders = Order::where('user_id', $user->id)
            ->latest()
            ->paginate(5);




        return view('user.index', compact(
            'user',
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders',
            'canceledOrders',
            'paginatedOrders',
        ));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(5);
        return view('user.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {

        abort_if(
            $order->user_id !== Auth::id(),
            403
        );

        return view('user.view', compact('order'));
    }
}