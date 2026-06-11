@extends('layouts.frontend.frontend')

@section('title', 'Cart-details')

<link rel="stylesheet" href="{{ asset('assets/website/styles/cart-details.css') }}">

@section('content')
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
                            <button class="qty_minus">-</button>

                            <input type="text" value="{{ $item->quantity }}">

                            <button class="qty_plus">+</button>
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
@endsection

<script src="{{ asset('assets/website/js/cart_custom.js') }}"></script>