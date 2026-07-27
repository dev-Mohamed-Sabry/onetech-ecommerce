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




        return view('user_account_profile.index', compact(
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


    public function view(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        // هات عناصر الطلب (items) ومع كل عنصر المنتج المرتبط به (product)

        $order->load([
            'items.product'
        ]);

        return view('user_account_profile.view', compact('order'));
    }
}
