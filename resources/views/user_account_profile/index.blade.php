@extends('layouts.user.user')


@section('css')
    <link rel="stylesheet" href='{{ asset('assets/website/styles/user_profile.css') }}'>

@endsection



@section('content')
    <div class="container account-wrapper">

        <!-- Hero Section -->
        <div class="account-hero">

            <div class="d-flex align-items-center">
                <div class="account-avatar mr-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div>
                    <h2 class="mb-1">My Profile</h2>

                    <p class="welcome-text mb-0">
                        Welcome back,
                        <span class="user-name">
                            {{ $user->name }}
                        </span>
                    </p>
                </div>
            </div>

        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-lg col-md-4 col-sm-6 mb-3">
                <div class="stat-box stat-total">
                    <div class="number">{{ $totalOrders ?? 0 }}</div>
                    <div class="label">Total Orders</div>
                </div>
            </div>

            <div class="col-lg col-md-4 col-sm-6 mb-3">
                <div class="stat-box stat-pending">
                    <div class="number">{{ $pendingOrders ?? 0 }}</div>
                    <div class="label">Pending Orders</div>
                </div>
            </div>

            <div class="col-lg col-md-4 col-sm-6 mb-3">
                <div class="stat-box stat-processing">
                    <div class="number">{{ $processingOrders ?? 0 }}</div>
                    <div class="label">Processing Orders</div>
                </div>
            </div>

            <div class="col-lg col-md-4 col-sm-6 mb-3">
                <div class="stat-box stat-delivered">
                    <div class="number">{{ $deliveredOrders ?? 0 }}</div>
                    <div class="label">Delivered Orders</div>
                </div>
            </div>

            <div class="col-lg col-md-4 col-sm-6 mb-3">
                <div class="stat-box stat-cancelled">
                    <div class="number">{{ $canceledOrders ?? 0 }}</div>
                    <div class="label">Cancelled Orders</div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Orders -->
            <div class="col-lg-8">

                <div class="section-card">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="section-title mb-0">
                            Recent Orders
                        </h4>
                        <span class="text-muted">
                            {{ $orders->total() }} Orders
                        </span>
                    </div>

                    @forelse($orders as $order)

                        <div class="order-row">
                            <div class="order-left">
                                <div class="order-id">
                                    # {{ $order->order_number }}
                                </div>
                                <div class="order-date">
                                    {{ $order->created_at->format('d M Y - h:i A') }}
                                </div>
                            </div>

                            <div class="order-right">
                                @if($order->status === 'pending')
                                    <span class="badge badge-warning">
                                        Pending
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="badge badge-info">
                                        Processing
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge badge-success">
                                        Delivered
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge badge-danger">
                                        Cancelled
                                    </span>
                                @endif

                                <strong class="order-total">
                                    {{ number_format($order->total, 2) }} EGP
                                </strong>

                                <a href="{{ route('order-details.view', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                    {{-- <a href="#" class="btn btn-outline-primary btn-sm"> --}}
                                        View
                                    </a>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-5">

                            <h5 class="text-muted">
                                No Orders Found
                            </h5>

                            <p class="text-muted mb-0">
                                You haven't placed any orders yet.
                            </p>

                        </div>

                    @endforelse

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>

                </div>

            </div>

            <!-- Account Info -->
            <div class="col-lg-4">

                <div class="section-card">

                    <h4 class="section-title">
                        Account Information
                    </h4>

                    <div class="account-info-item">

                        <label>Name</label>

                        <div>
                            Mohamed Sabry
                        </div>

                    </div>

                    <div class="account-info-item">

                        <label>Email</label>

                        <div>
                            mo7ammed.sabre@gmail.com
                        </div>

                    </div>

                    <div class="account-info-item">

                        <label>Phone</label>

                        <div>
                            01012537622
                        </div>

                    </div>

                    <div class="account-info-item">

                        <label>Member Since</label>

                        <div>
                            July 2026
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection