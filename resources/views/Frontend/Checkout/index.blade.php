@extends('layouts.frontend.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/website/styles/checkout.css') }}">
@endsection


@section('content')

    {{-- @dd($cart) --}}

    <div class="checkout_page container">

        <div class="checkout_title">
            <h3>Checkout</h3>
        </div>

        <div class="checkout_wrapper">

            <div class="checkout_form_box">

                <h4>Billing Details</h4>

                <form id="checkout-form" method="POST">

                    @csrf

                    <div class="form_group">
                        <label>Full Name</label>
                        <input required type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
                    </div>

                    <div class="form_group">
                        <label>Email</label>
                        <input required type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                    </div>

                    <div class="form_group">
                        <label>Phone</label>
                        <input required type="tel" name="phone">
                    </div>

                    <div class="form_group">
                        <label>Governorate</label>
                        <input required type="text" name="governorate">
                    </div>

                    <div class="form_group">
                        <label>City</label>
                        <input required type="text" name="city">
                    </div>

                    <div class="form_group">
                        <label>Address</label>
                        <textarea name="address" rows="3"></textarea>
                    </div>

                    <div class="form_group">
                        <label>Notes</label>
                        <textarea name="note"></textarea>
                    </div>

                    <div class="form_group payment_method_group">

                        <label>Payment Method</label>

                        <div class="payment_option">

                            <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery"
                                checked>

                            <label for="cash_on_delivery">
                                Cash on Delivery
                            </label>

                        </div>

                    </div>

                </form>
            </div>

            <div class="order_summary">

                <div class="checkout_summary">

                    <div class="summary_title">
                        Order Summary
                    </div>

                    <div class="summary_items">

                        @forelse ($cart as $item)

                            <div class="summary_item">

                                <div class="summary_item_image">
                                    <a href="{{ route('product.details', $item->product->id) }}">
                                        <img src="{{ $item?->product?->image ?? asset('uploads/products/no_img.jpg')}}"
                                            alt="{{ $item->product->name }}">
                                    </a>
                                </div>

                                <div class="summary_item_content">

                                    <div class="summary_item_name">
                                        {{ $item->product->name }}
                                    </div>

                                    <div class="summary_item_price">
                                        Price:
                                        <span>{{ $item->product->final_price }} EGP</span>
                                    </div>

                                    <div class="summary_item_qty">
                                        Quantity:
                                        <span>{{ $item->quantity }}</span>
                                    </div>

                                    <div class="summary_item_total">
                                        Total:
                                        <span>
                                            {{ $item->product->final_price * $item->quantity }} EGP
                                        </span>
                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="empty_summary">
                                No products found
                            </div>

                        @endforelse

                    </div>

                    <div class="summary_total">
                        Order Total:
                        <span>{{ number_format($total, 2) }} EGP</span>
                    </div>

                </div>
                <button type="submit" form="checkout-form" class="place_order_btn">
                    Place Order
                </button>

            </div>

        </div>

    </div>
@endsection


@section('script')

@endsection