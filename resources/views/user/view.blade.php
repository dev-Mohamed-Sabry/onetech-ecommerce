@extends('layouts.user.user')


@section('title', 'Order Details')

@section('css')
    <link rel="stylesheet" href='{{ asset('assets/website/styles/user_profile.css') }}'>

@endsection

@section('content')
    <div class="container product-details-page">

        <div class="row">

            <div class="col-lg-5">

                <div class="product-image-card">
                    {{-- {{ dd($product) }} --}}
                    <img src="{{  asset('uploads/products/no_img.jpg')}}" class="img-fluid" alt="{{ $product->name }}">

                </div>

            </div>

            <div class="col-lg-7">

                <div class="product-info-card">

                    <span class="product-category">
                        {{ $product->category?->name }}
                    </span>

                    <h1 class="product-title">
                        {{ $product->name }}
                    </h1>

                    <div class="product-price">

                        <span class="current-price">
                            {{ number_format($product->final_price, 2) }} EGP
                        </span>

                        @if($product->discount_value > 0)

                            <span class="old-price">
                                {{ number_format($product->base_price, 2) }} EGP
                            </span>

                        @endif

                    </div>

                    <p class="product-short-description">
                        {{ Str::limit(strip_tags($product->description), 150) }}
                    </p>

                    <div class="stock-status">

                        @if($product->quantity > 0)

                            <span class="badge badge-success">
                                In Stock
                            </span>

                        @else

                            <span class="badge badge-danger">
                                Out Of Stock
                            </span>

                        @endif

                    </div>

                    <div class="product_quantity mt-4">

                        <span class="mr-3">
                            Quantity
                        </span>

                        <input id="quantity_input" type="text" value="1">

                    </div>

                    <button id="cart_button" data-product-id="{{ $product->id }}" class="btn btn-primary btn-lg mt-4">

                        Add To Cart

                    </button>

                </div>

            </div>

        </div>

        <div class="section-card mt-5">

            <h3>Product Description</h3>

            {!! $product->description !!}

        </div>

    </div>
@endsection