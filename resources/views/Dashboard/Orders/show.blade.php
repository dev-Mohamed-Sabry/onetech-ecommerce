@extends('layouts.dashboard.dashboard')


@section('title', 'Order Details')

@section('content')
    <div class="sl-mainpanel">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 mt-5">

                    <div class="card mb-4">

                        <div class="card-header">
                            <h4>
                                Order #{{ $order->id }}
                            </h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-3">
                                    <strong>Status</strong>
                                    <div class="mt-2">

                                        @if($order->status === 'pending')
                                            <span class="badge badge-warning p-2 rounded-50">
                                                Pending
                                            </span>

                                        @elseif($order->status === 'processing')
                                            <span class="badge badge-info p-2 rounded-50">
                                                Processing
                                            </span>

                                        @elseif($order->status === 'delivered')
                                            <span class="badge badge-success p-2 rounded-50">
                                                Delivered
                                            </span>

                                        @elseif($order->status === 'cancelled')
                                            <span class="badge badge-danger p-2 rounded-50">
                                                Cancelled
                                            </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <strong>Total</strong>
                                    <div class="mt-2">
                                        {{ number_format($order->total, 2) }} EGP
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <strong>Payment</strong>
                                    <div class="mt-2">
                                        {{ $order->payment_method }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <strong>Date</strong>
                                    <div class="mt-2">
                                        {{ $order->created_at->format('Y-m-d h:i A') }}
                                    </div>
                                </div>

                            </div>



                        </div>

                    </div>

                </div>

            </div>

            <div class="row mb-5 pb-5">

                <div class="col-md-4">

                    <div class="card">

                        <div class="card-header">
                            Customer Information
                        </div>

                        <div class="card-body">

                            <p><strong>Name:</strong> {{ $order->name }}</p>

                            <p><strong>Email:</strong> {{ $order->email }}</p>

                            <p><strong>Phone:</strong> {{ $order->phone }}</p>

                            <p><strong>Governorate:</strong> {{ $order->governorate }}</p>

                            <p><strong>City:</strong> {{ $order->city }}</p>

                            <p><strong>Address:</strong> {{ $order->address }}</p>

                            @if($order->notes)
                                <p><strong>Notes:</strong> {{ $order->notes }}</p>
                            @endif

                        </div>

                    </div>

                </div>

                <div class="col-md-8">

                    <div class="card">

                        <div class="card-header">
                            Order Items
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered">

                                <thead>

                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($order->items as $item)

                                        <tr>

                                            <td>
                                                {{ $item->product?->name }}
                                            </td>

                                            <td>
                                                {{ number_format($item->price, 2) }} EGP
                                            </td>

                                            <td>
                                                {{ $item->quantity }}
                                            </td>

                                            <td>
                                                {{ number_format($item->item_total, 2) }} EGP
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th colspan="3" class="text-end">
                                            Grand Total
                                        </th>

                                        <th>
                                            {{ number_format($order->total, 2) }} EGP
                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection