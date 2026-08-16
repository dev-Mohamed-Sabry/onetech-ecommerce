{{-- {{ dd($hotSaleProducts) }} --}}



@extends('layouts.frontend.frontend')

@section('title', 'Home')

@section('content')

    <!-- Banner -->

    <div class="banner">
        <div class="banner_background"
            style="background-image:url({{asset('assets/website/images/banner_background.jpg')}})"></div>
        <div class="container fill_height">
            <div class="row fill_height">

                <div class="banner_product_image">
                    <img src="{{ asset($bannerProduct->image ?? 'uploads/products/no_img.jpg') }}" width="400"
                        alt="{{ $bannerProduct->name ?? 'Banner Product'}}">
                </div>

                <div class="col-lg-5 offset-lg-4 fill_height">

                    <div class="banner_content">

                        <h1 class="banner_text">
                            {{ __('messages.banner_title') }}
                        </h1>

                        <div class="banner_price">

                            @if($bannerProduct->base_price > $bannerProduct->final_price)
                                <span>
                                    {{ number_format($bannerProduct->base_price, 2) }}
                                </span>
                            @endif

                            {{ number_format($bannerProduct->final_price, 2) }} EGP

                        </div>

                        <div class="banner_product_name">
                            {{ Str::limit($bannerProduct->name, 25, '...') }}
                        </div>

                        <div class="button banner_button">

                            <a href="{{ route('products.by.category', $bannerProduct->category->id) }}">
                                {{ __('messages.shop_now') }}
                            </a>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Characteristics -->

    <div class="characteristics">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 char_col">
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">

                        <div class="char_icon">
                            <img src="{{ asset('assets/website/images/char_1.png') }}" alt="">
                        </div>

                        <div class="char_content">
                            <div class="char_title">
                                {{ __('messages.free_shipping') }}
                            </div>

                            <div class="char_subtitle">
                                {{ __('messages.free_shipping_desc') }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 char_col">
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">

                        <div class="char_icon">
                            <img src="{{ asset('assets/website/images/char_2.png') }}" alt="">
                        </div>

                        <div class="char_content">
                            <div class="char_title">
                                {{ __('messages.money_guarantee') }}
                            </div>

                            <div class="char_subtitle">
                                {{ __('messages.money_guarantee_desc') }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 char_col">
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">

                        <div class="char_icon">
                            <img src="{{ asset('assets/website/images/char_3.png') }}" alt="">
                        </div>

                        <div class="char_content">
                            <div class="char_title">
                                {{ __('messages.online_support') }}
                            </div>

                            <div class="char_subtitle">
                                {{ __('messages.online_support_desc') }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 char_col">
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">

                        <div class="char_icon">
                            <img src="{{ asset('assets/website/images/char_4.png') }}" alt="">
                        </div>

                        <div class="char_content">
                            <div class="char_title">
                                {{ __('messages.secure_payment') }}
                            </div>

                            <div class="char_subtitle">
                                {{ __('messages.secure_payment_desc') }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Deals of the week -->

    <div class="deals_featured">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">

                    <!-- Deals -->

                    <div class="deals">
                        <div class="deals_title">{{ __('messages.deals_of_the_week') }}</div>
                        <div class="deals_slider_container">

                            <!-- Deals Slider -->
                            <div class="owl-carousel owl-theme deals_slider">

                                @foreach ($products_deals_of_the_week as $product)
                                    <!-- Deals Item -->
                                    <div class="owl-item deals_item">
                                        <a href="{{ route('product.details', $product) }}">
                                            <div class="deals_image">
                                                <img src="{{$product->image ?? asset('uploads/products/no_img.jpg') }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                            <div class="deals_content">
                                                <div class="deals_info_line d-flex flex-row justify-content-start">
                                                    <div class="deals_item_category"><a
                                                            href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
                                                    </div>


                                                    @if ($product->discount_value > 0)
                                                        <span class="deals_item_price_a ml-auto"
                                                            style="text-decoration: line-through !important;">
                                                            {{ number_format($product->base_price, 2) }} EGP
                                                            {{-- 500 --}}
                                                        </span>
                                                        {{-- @else
                                                        <div class="deals_item_price_a ml-auto">
                                                            {{ $product->final_price }}
                                                        </div> --}}

                                                    @endif
                                                </div>
                                                <div class="deals_info_line">
                                                    <div class="deals_item_price">
                                                        <span
                                                            style="color:#999999; font-size: 20px;">{{ __('messages.limited_time') }}</span>
                                                        {{ number_format($product->final_price, 2) }} EGP
                                                    </div>
                                                    <br>
                                                    <div class="deals_item_name">{{Str::limit($product->name, 25, '...')}}</div>
                                                </div>
                                                <div class="available">
                                                    <div class="available_line d-flex flex-row justify-content-start">
                                                        <div class="available_title">{{ __('messages.limited_time') }}
                                                            <span>
                                                                @if ($product->quantity > 0)
                                                                    {{ $product->quantity }}
                                                                @else
                                                                    {{ __('messages.out_of_stock') }}
                                                                @endif

                                                            </span>
                                                        </div>
                                                        {{-- <div class="sold_title ml-auto">Already sold: <span>28</span></div>
                                                        --}}
                                                    </div>
                                                    <div class="available_bar"><span style="width:17%"></span></div>
                                                </div>
                                                <div
                                                    class="deals_timer d-flex flex-row align-items-center justify-content-start">
                                                    <div class="deals_timer_title_container">
                                                        <div class="deals_timer_title">{{ __('messages.hurry_up') }}</div>
                                                        <div class="deals_timer_subtitle">{{ __('messages.offer_ends_in') }}
                                                        </div>
                                                    </div>
                                                    <div class="deals_timer_content ml-auto">
                                                        <div class="deals_timer_box clearfix" data-target-time="">
                                                            <div class="deals_timer_unit">
                                                                <div id="deals_timer1_hr" class="deals_timer_hr"></div>
                                                                <span>{{ __('messages.hours') }}</span>
                                                            </div>
                                                            <div class="deals_timer_unit">
                                                                <div id="deals_timer1_min" class="deals_timer_min"></div>
                                                                <span>{{ __('messages.minutes') }}</span>
                                                            </div>
                                                            <div class="deals_timer_unit">
                                                                <div id="deals_timer1_sec" class="deals_timer_sec"></div>
                                                                <span>{{ __('messages.seconds') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                            </div>

                        </div>

                        <div class="deals_slider_nav_container">
                            <div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i>
                            </div>
                            <div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Featured -->
                    <div class="featured">
                        <div class="tabbed_container">
                            <div class="tabs">
                                <ul class="clearfix">
                                    <li class="active">
                                        {{ __('messages.featured_products') }}
                                    </li>

                                    <li>
                                        {{ __('messages.hot_sale') }}
                                    </li>
                                </ul>

                                <div class="tabs_line">
                                    <span></span>
                                </div>
                            </div>

                            <!--Featured Product Panel -->
                            <div class="product_panel panel active">
                                <div class="featured_slider slider">
                                    <!-- Slider Item -->
                                    @foreach ($featuredProducts as $product)
                                            <div class="featured_slider_item">
                                                <div class="border_active"></div>
                                                <div
                                                    class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">

                                                    <a href="{{ route('product.details', $product->id)}}">
                                                        <div
                                                            class="product_image d-flex flex-column align-items-center justify-content-center">
                                                            <img src="{{ $product->image ?? asset('uploads/products/no_img.jpg')}}"
                                                                alt="{{$product->image ?? 'No Img'}}" height="100" width="100">
                                                        </div>

                                                        <div class="product_content">
                                                            <div
                                                                class="product_price {{ $product->discount_value > 0 ? 'discount' : '' }}">
                                                                @if ($product->discount_value > 0)
                                                                    {{ number_format($product->final_price, 2) }} EGP
                                                                    <span
                                                                        style="text-decoration: line-through !important;">{{ number_format($product->base_price, 2) }}
                                                                        EGP</span>
                                                                @else
                                                                    {{ number_format($product->base_price, 2) }} EGP
                                                                @endif

                                                            </div>
                                                            <div class="product_name">
                                                                <div>
                                                                    <p>{{ Str::limit($product->name, 25, '...') }}</p>
                                                                </div>
                                                            </div>
                                                    </a>

                                                    <div class="product_extras">
                                                        <button id="cart_button" class="product_cart_button add-to-cart"
                                                            data-product-id="{{ $product->id }}">
                                                            {{ __('messages.add_to_cart') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="product_fav active" data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-heart"></i>
                                                </div>
                                                <ul class="product_marks">
                                                    @if ($product->discount_value > 0)

                                                        <li class="product_mark product_discount">
                                                            @if ($product->discount_type == 'percent')
                                                                -{{ $product->discount_value }}%
                                                            @else
                                                                -{{ $product->discount_value }}
                                                            @endif
                                                        </li>

                                                    @endif

                                                    @if ($product->created_at->gt(now()->subDays(7)))
                                                        <li class="product_mark product_new">{{ __('messages.new') }}</li>
                                                    @endif
                                                </ul>

                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                        </div>

                        <!--Hot Sale Product Panel -->
                        <div class="product_panel panel">
                            <div class="featured_slider slider">
                                <!-- Slider Item -->
                                @foreach ($hotSaleProducts as $product)
                                        <div class="featured_slider_item">
                                            <div class="border_active"></div>
                                            <div
                                                class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                <a href="{{ route('product.details', $product->id)}}">
                                                    <div
                                                        class="product_image d-flex flex-column align-items-center justify-content-center">
                                                        <img src="{{ $product->image ?? asset('uploads/products/no_img.jpg')}}"
                                                            alt="{{$product->image ?? 'No Img'}}" height="100" width="100">
                                                    </div>
                                                    <div class="product_content">
                                                        <div
                                                            class="product_price {{ $product->discount_value > 0 ? 'discount' : '' }}">
                                                            @if ($product->discount_value > 0)
                                                                {{ number_format($product->final_price, 2) }} EGP
                                                                <span
                                                                    style="text-decoration: line-through !important;">{{ number_format($product->base_price, 2) }}
                                                                    EGP</span>
                                                            @else
                                                                {{ number_format($product->base_price, 2) }} EGP
                                                            @endif

                                                        </div>
                                                        <div class="product_name">
                                                            <div>
                                                                <p>{{ Str::limit($product->name, 25, '...') }}</p>
                                                            </div>
                                                        </div>
                                                </a>
                                                <div class="product_extras">
                                                    <button class="product_cart_button add-to-cart"
                                                        data-product-id="{{ $product->id }}">{{ __('messages.add_to_cart') }}</button>
                                                </div>
                                            </div>
                                            <div class="product_fav active" data-product-id="{{ $product->id }}"><i
                                                    class="fas fa-heart"></i></div>
                                            <ul class="product_marks">
                                                @if ($product->discount_value > 0)

                                                    <li class="product_mark product_discount">
                                                        @if ($product->discount_type == 'percent')
                                                            -{{ $product->discount_value }}%
                                                        @else
                                                            -{{ $product->discount_value }}
                                                        @endif
                                                    </li>

                                                @endif

                                                @if ($product->created_at->gt(now()->subDays(7)))
                                                    <li class="product_mark product_new">{{ __('messages.new') }}</li>
                                                @endif
                                            </ul>

                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>

                    <div class="featured_slider_dots_cover"></div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>

    <!-- Popular Categories -->

    <div class="popular_categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="popular_categories_content">

                        <div class="popular_categories_title">
                            {{ __('messages.popular_categories') }}
                        </div>

                        <div class="popular_categories_slider_nav">

                            <div class="popular_categories_prev popular_categories_nav">
                                <i class="fas fa-angle-left ml-auto"></i>
                            </div>

                            <div class="popular_categories_next popular_categories_nav">
                                <i class="fas fa-angle-right ml-auto"></i>
                            </div>

                        </div>

                        <div class="popular_categories_link">

                            <a href="{{ route('products.by.category', $product_by_category->category->id) }}">
                                {{ __('messages.full_catalog') }}
                            </a>

                        </div>

                    </div>
                </div>

                <!-- Popular Categories Slider -->

                <div class="col-lg-9">
                    <div class="popular_categories_slider_container">
                        <div class="owl-carousel owl-theme popular_categories_slider">

                            <!-- Categories  -->

                            @forelse ($categories as $category)
                                <div class="owl-item">
                                    <a href="{{ route('categories.show', $category) }}">
                                        <div
                                            class="popular_category d-flex flex-column align-items-center justify-content-center">
                                            <div class="popular_category_image"><img
                                                    src="{{ asset('uploads/categories/' . $category->image) }}"
                                                    alt="{{  $category?->name }}">
                                            </div>
                                            <div class="popular_category_text">{{ __('messages.smartphones_tablets') }}</div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="text-danger">No Categories Found</div>
                            @endforelse




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner -->

    <div class="banner_2">
        <div class="banner_2_background"
            style="background-image:url({{asset('assets/website/images/banner_2_background.jpg')}})"></div>
        <div class="banner_2_container">
            <div class="banner_2_dots"></div>
            <!-- Banner 2 Slider -->

            <div class="owl-carousel owl-theme banner_2_slider">

                <!-- Banner 2 Slider Item -->
                @foreach ($laptopCategory_latest_products as $product)
                    <div class="owl-item">
                        <div class="banner_2_item">
                            <div class="container fill_height">
                                <div class="row fill_height">
                                    <div class="col-lg-4 col-md-6 fill_height">
                                        <div class="banner_2_content">
                                            <div class="banner_2_category">{{ $product->category->name }}</div>
                                            <div class="banner_2_title">{{ Str::limit($product->name, 24) }}
                                            </div>
                                            <div class="banner_2_text">
                                                <p> {{ Str::limit(strip_tags($product->description), 200) }}
                                                </p>
                                            </div>
                                            <div class="rating_r rating_r_4 banner_2_rating">
                                                <i></i><i></i><i></i><i></i><i></i>
                                            </div>
                                            <div class="button banner_2_button"><a
                                                    href="{{ route('product.details', $product) }}">{{ __('messages.explore') }}</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-8 col-md-6 fill_height">
                                        <div class="banner_2_image_container">
                                            <div class="banner_2_image">
                                                <a href="{{ route('product.details', $product) }}">
                                                    <img src="{{ $product->image ?? asset('uploads/products/no_img.jpg')}}"
                                                        alt="{{ $product->name }}" style="width: 75%;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>


    <!-- Recently Viewed -->
    {{-- @if ($recentlyViewedProducts->count())
    <div class="viewed">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="viewed_title_container">
                        <h3 class="viewed_title">{{ __('messages.recently_viewed') }}</h3>
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
                                                                                        : asset('uploads/products/no_img.jpg') }}"
                                                alt="{{ $recent->product->name }}">
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

    @endif --}}

    @if ($recentlyViewedProducts->count())
        <div class="viewed">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="viewed_title_container">
                            <h3 class="viewed_title">{{ __('messages.recently_viewed') }}</h3>
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
    <!-- Brands -->

    <div class="brands">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="brands_slider_container">

                        <!-- Brands Slider -->

                        <div class="owl-carousel owl-theme brands_slider">

                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_1.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_2.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_3.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_4.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_5.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_6.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_7.jpg')}}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{asset('assets/website/images/brands_8.jpg')}}" alt=""></div>
                            </div>

                        </div>

                        <!-- Brands Slider Navigation -->
                        <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection