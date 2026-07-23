@extends('layouts.user.user')

@section('title', 'Order Details')

@section('css')

    <link rel="stylesheet" href="{{ asset('assets/website/styles/user_profile.css') }}">
@endsection

@section('content')

    <div class="container account-wrapper">

        <div class="mb-4">

            <a href="{{ route('account.index') }}" class="btn btn-outline-primary">

                <i class="fa fa-arrow-left mr-2"></i>

                Back To My Account

            </a>

        </div>

        <div class="section-card mb-4">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h3 class="mb-2">
                        Order # {{ $order->order_number }}
                    </h3>

                    <p class="text-muted mb-0">
                        {{ $order->created_at->format('d M Y - h:i A') }}
                    </p>

                </div>

                <div class="col-md-4 text-md-right mt-3 mt-md-0">

                    @if($order->status === 'pending')
                        <span class="badge badge-warning p-2">
                            Pending
                        </span>
                    @elseif($order->status === 'processing')
                        <span class="badge badge-info p-2">
                            Processing
                        </span>
                    @elseif($order->status === 'delivered')
                        <span class="badge badge-success p-2">
                            Delivered
                        </span>
                    @elseif($order->status === 'cancelled')
                        <span class="badge badge-danger p-2">
                            Cancelled
                        </span>
                    @endif

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-4">

                <div class="section-card">

                    <h4 class="section-title">
                        Shipping Information
                    </h4>

                    <div class="account-info-item">
                        <label>Name</label>
                        <div>{{ $order->name }}</div>
                    </div>

                    <div class="account-info-item">
                        <label>Email</label>
                        <div>{{ $order->email }}</div>
                    </div>

                    <div class="account-info-item">
                        <label>Phone</label>
                        <div>{{ $order->phone }}</div>
                    </div>

                    <div class="account-info-item">
                        <label>Governorate</label>
                        <div>{{ $order->governorate }}</div>
                    </div>

                    <div class="account-info-item">
                        <label>City</label>
                        <div>{{ $order->city }}</div>
                    </div>

                    <div class="account-info-item">
                        <label>Address</label>
                        <div>{{ $order->address }}</div>
                    </div>

                    @if($order->notes)
                        <div class="account-info-item">
                            <label>Notes</label>
                            <div>{{ $order->notes }}</div>
                        </div>
                    @endif

                </div>

            </div>

            <div class="col-lg-8">

                <div class="section-card">

                    <h4 class="section-title">
                        Ordered Products
                    </h4>
                    {{-- {{dd($order->items)}} --}}
                    @foreach($order->items as $item)
                        <div class="order-row">

                            <div class="d-flex align-items-center">

                                <img src="{{ asset($item->product->image ?? 'uploads/products/no_img.jpg') }}" width="80"
                                    height="80" style="object-fit:cover;border-radius:8px;">

                                <div class="ml-3">

                                    <div class="font-weight-bold">
                                        {{ $item->product->name }}
                                    </div>

                                    <div class="text-muted">
                                        Qty: {{ $item->quantity }}
                                    </div>

                                </div>

                            </div>

                            <div class="text-right">

                                <div>
                                    {{ number_format($item->price, 2) }} EGP
                                </div>

                                <strong>
                                    {{ number_format($item->item_total, 2) }} EGP
                                </strong>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="section-card">

                    <h4 class="section-title">
                        Order Summary
                    </h4>

                    <div class="d-flex justify-content-between mb-3">

                        <span>Payment Method</span>

                        <strong>
                            {{ ucfirst($order->payment_method) }}
                        </strong>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <h5 class="mb-0">
                            Total
                        </h5>

                        <h4 class="text-primary mb-0">
                            {{ number_format($order->total, 2) }} EGP
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection