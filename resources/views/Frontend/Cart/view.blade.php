@extends('layouts.frontend.frontend')

@section('title', 'Cart-details')

<link rel="stylesheet" href="{{ asset('assets/website/styles/cart-details.css') }}">

@section('content')

    <!-- Cart Products -->
    <div class="cart_page container">
        <div class="cart_title">
            <h3>Your Cart</h3>
        </div>

        <div class="cart_wrapper">
            @forelse($cart as $item)
                <div class="cart_row" data-product-id="{{ $item->product_id }}">

                    {{-- Product Image --}}
                    <div class="cart_col image">
                        <img src="{{ $item->product->image ?? asset('uploads/products/no_img.jpg') }}">
                    </div>

                    {{-- Product Name --}}
                    <div class="cart_col name">
                        <div class="product_name">
                            {{ $item->product->name }}
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="cart_col price">
                        <span>Price</span>
                        <div class="value">
                            {{ $item->product->final_price }} EGP
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div class="cart_col qty">

                        <div class="qty_box">
                            <button class="qty-plus">+</button>
                            <input type="text" value="{{ $item->quantity }}">
                            <button class="qty-minus">-</button>

                        </div>

                    </div>

                    {{-- Total --}}
                    <div class="cart_col total">
                        <span>Total</span>
                        <div class="value">
                            {{ $item->product->final_price * $item->quantity }} EGP
                        </div>
                    </div>

                    {{-- Remove --}}
                    <div class="cart_col remove">
                        <button class="remove_btn">×</button>
                    </div>
                </div>
            @empty
                <div class="empty_cart">
                    Your cart is empty
                </div>
            @endforelse

        </div>

        {{-- Footer --}}
        <div class="cart_footer">

            <div class="cart_total_box">
                Total:
                <span id="cart-total">{{ $total }} EGP</span>
            </div>

            <a href="/checkout" class="checkout_btn">
                Checkout
            </a>

        </div>

    </div>

    <!-- Recently Viewed -->
    @if ($recentlyViewedProducts->count())
        <div class="viewed">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="viewed_title_container">
                            <h3 class="viewed_title">Recently Viewed</h3>
                            <div class="viewed_nav_container">
                                <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                                <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                            </div>
                        </div>
                        <div class="viewed_slider_container">

                            <!-- Recently Viewed Slider -->

                            <div class="owl-carousel owl-theme viewed_slider">

                                @foreach ($recentlyViewedProducts as $recent)

                                    @if ($recent->product)

                                                <div class="owl-item">

                                                    <a href="{{ route('product.details', $recent->product->id) }}">

                                                        <div
                                                            class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">

                                                            <div class="viewed_image">

                                                                <img src="{{ $recent->product->image
                                        ? asset($recent->product->image)
                                        : asset('uploads/products/no_img.jpg') }}" alt="{{ $recent->product->name }}">

                                                            </div>

                                                            <div class="viewed_content text-center">

                                                                <div class="viewed_price">

                                                                    @if ($recent->product->discount_value > 0)

                                                                        {{ $recent->product->final_price }} EGP
                                                                        <span>{{ $recent->product->base_price }}</span>

                                                                    @else

                                                                        {{ $recent->product->base_price }} EGP

                                                                    @endif

                                                                </div>

                                                                <div class="viewed_name">
                                                                    <span>{{ Str::limit($recent->product->name, 25) }}</span>
                                                                </div>

                                                            </div>

                                                            <ul class="item_marks">

                                                                @if ($recent->product->discount_value > 0)

                                                                    <li class="item_mark item_discount">

                                                                        @if ($recent->product->discount_type == 'percent')

                                                                            -{{ $recent->product->discount_value }}%

                                                                        @else

                                                                            -{{ $recent->product->discount_value }} EGP

                                                                        @endif

                                                                    </li>

                                                                @endif

                                                                @if ($recent->product->created_at->gt(now()->subDays(7)))

                                                                    <li class="item_mark item_new">new</li>

                                                                @endif

                                                            </ul>

                                                        </div>

                                                    </a>

                                                </div>

                                    @endif

                                @endforeach

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection



@section('script')
    <script src="{{ asset('assets/website/js/product_custom.js') }}"></script>
@endsection