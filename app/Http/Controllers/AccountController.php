<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $status = $request->status;

        $orders = Order::where('user_id', $user->id)
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $totalOrders = Order::where('user_id', $user->id)->count();

        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $processingOrders = Order::where('user_id', $user->id)
            ->where('status', 'processing')
            ->count();

        $deliveredOrders = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->count();

        $canceledOrders = Order::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->count();

        $ordersTitle = match ($status) {
            'pending' => 'Pending Orders',
            'processing' => 'Processing Orders',
            'delivered' => 'Delivered Orders',
            'cancelled' => 'Cancelled Orders',
            default => 'Recent Orders',
        };

        return view('user_account_profile.index', compact(
            'user',
            'orders',
            'ordersTitle',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders',
            'canceledOrders',
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