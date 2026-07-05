@extends('layouts.frontend.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/website/styles/checkout.css') }}">
@endsection

@section('content')


    <div class="checkout_page container">

        <div class="checkout_title">
            <h3>Checkout</h3>
        </div>

        <div class="checkout_wrapper">

            <div class="checkout_form_box">

                <h4>Billing Details</h4>

                <form id="checkout-form">

                    <div class="form_group">
                        <label>Full Name</label>
                        <input type="text">
                    </div>

                    <div class="form_group">
                        <label>Phone</label>
                        <input type="text">
                    </div>

                    <div class="form_group">
                        <label>City</label>
                        <input type="text">
                    </div>

                    <div class="form_group">
                        <label>Address</label>
                        <textarea></textarea>
                    </div>

                    <div class="form_group">
                        <label>Notes</label>
                        <textarea></textarea>
                    </div>

                </form>

            </div>

            <div class="order_summary">

                <h4>Order Summary</h4>

                <div class="summary_items">

                    <!-- Products -->

                </div>

                <div class="summary_total">
                    Total: 0 EGP
                </div>

                <button class="place_order_btn">
                    Place Order
                </button>

            </div>

        </div>

    </div>
@endsection


@section('script')

@endsection