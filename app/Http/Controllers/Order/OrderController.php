<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (request()->ajax()) {

            $orders = Order::with('user')
                ->select(
                    'id',
                    'user_id',
                    'name',
                    'phone',
                    'governorate',
                    'city',
                    'address',
                    'notes',
                    'payment_method',
                    'total',
                    'status',
                    'created_at',
                );

            return DataTables::of($orders)

                ->addColumn('action', function ($order) {

                    $statuses = '';

                    if ($order->status === 'pending') {

                        $statuses .= '
            <option value="processing">Processing</option>
            <option value="cancelled">Cancelled</option>
        ';
                    } elseif ($order->status === 'processing') {

                        $statuses .= '
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        ';
                    }

                    return '
    <div style="display:flex;align-items:center;gap:10px;">

        <a href="' . route('orders.show', $order->id) . '"
            class="btn btn-sm btn-primary">
            View
        </a>

        <select
            class="status-select change-status"
            data-id="' . $order->id . '">

            <option value="">Update Status</option>

            ' . $statuses . '

        </select>

    </div>
';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('Y-m-d h:i A');
                })
                ->editColumn('status', function ($order) {

                    return match ($order->status) {

                        'pending' =>
                        '<span class="order-status status-pending">
                            Pending
                        </span>',

                        'processing' =>
                        '<span class="order-status status-processing">
                            Processing
                        </span>',

                        'delivered' =>
                        '<span class="order-status status-delivered">
                            Delivered
                        </span>',

                        'cancelled' =>
                        '<span class="order-status status-cancelled">
                            Cancelled
                        </span>',

                        default =>
                        '<span class="order-status">
                            Unknown
                        </span>',
                    };
                })
                ->rawColumns([
                    'status',
                    'action'
                ])

                ->make(true);
        }


        return view('Dashboard.Orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'items.product'
        ]);

        return view(
            'Dashboard.Orders.show',
            compact('order')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $allowed = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['delivered', 'cancelled'],
            'delivered' => [],
            'cancelled' => [],
        ];

        if (!in_array($request->status, $allowed[$order->status])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition'
            ], 422);
        }

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}