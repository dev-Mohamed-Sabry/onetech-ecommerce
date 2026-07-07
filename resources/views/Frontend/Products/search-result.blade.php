@extends('layouts.frontend.frontend')


@section('title', 'Products By Category')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/shop_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/shop_responsive.css') }}">
@endsection

@section('content')
    <!-- Home -->

    <div class="home">
        <div class="home_background parallax-window" data-parallax="scroll"
            data-image-src="{{ asset('assets/website/images/shop_background.jpg') }}">
        </div>
        <div class="home_overlay"></div>
        <div class="home_content d-flex flex-column align-items-center justify-content-center">
            <h2 class="home_title">Search Results</h2>
        </div>
    </div>

    <!-- Shop -->

    <div class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <!-- Shop Sidebar -->
                    <div class="shop_sidebar">
                        <div class="sidebar_section">
                            <div class="sidebar_title">Categories</div>
                            <ul class="sidebar_categories">
                                @forelse ($categories as $category)
                                    <li>
                                        <a class="clc"
                                            href="{{ route('products.by.category', $category) }}">{{ $category->name }}
                                        </a>
                                    </li>

                                @empty
                                    <li class=" text-danger">No Categories Found
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-lg-9">

                    <!-- Shop Content -->

                    <div class="shop_content">
                        <div class="shop_bar clearfix">
                            <div class="shop_product_count"><span>{{ count($products) }}</span> products found</div>
                        </div>

                        <div class="product_grid">

                            <div class="product_grid_border"></div>

                            @forelse ($products as $product)

                                                <div class="product_item">

                                                    <a href="{{ route('product.details', $product->id) }}">

                                                        <div
                                                            class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">

                                                            <div class="viewed_image">

                                                                <img src="{{ $product->image
                                ? asset($product->image)
                                : asset('uploads/products/no_img.jpg') }}" alt="{{ $product->name }}" width="120"
                                                                    height="120">
                                                            </div>

                                                            <div class="viewed_content text-center">

                                                                <div class="viewed_price">

                                                                    @if ($product->discount_value > 0)

                                                                        {{ $product->final_price }} EGP
                                                                        <span>{{ $product->base_price }} EGP</span>

                                                                    @else

                                                                        {{ $product->base_price }} EGP

                                                                    @endif

                                                                </div>

                                                                <div class="viewed_name">
                                                                    <span>
                                                                        {{ Str::limit($product->name, 25, '...') }}
                                                                    </span>
                                                                </div>

                                                            </div>

                                                            <ul class="item_marks">

                                                                @if ($product->discount_value > 0)

                                                                    <li class="item_mark item_discount">

                                                                        @if ($product->discount_type == 'percent')

                                                                            -{{ $product->discount_value }}%

                                                                        @else

                                                                            -{{ $product->discount_value }} EGP

                                                                        @endif

                                                                    </li>

                                                                @endif

                                                                @if ($product->created_at->gt(now()->subDays(7)))

                                                                    <li class="item_mark item_new">
                                                                        new
                                                                    </li>

                                                                @endif

                                                            </ul>

                                                        </div>

                                                    </a>

                                                </div>

                            @empty

                                <div class="col-12">
                                    <div class="alert alert-danger text-center">
                                        No Products Found
                                    </div>
                                </div>

                            @endforelse

                        </div>

                        {{-- <div class="mt-4 d-flex justify-content-center">
                            {{ $products->links() }}
                        </div> --}}
                    </div>



                    <!-- Shop Page Navigation -->

                    {{-- {{ $products->links() }} --}}

                </div>
            </div>
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
                                        ? asset('uploads/products/' . $recent->product->image)
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

    <script src="{{ asset('assets/website/plugins/jquery-ui-1.12.1.custom/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/Isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/parallax-js-master/parallax.min.js') }}"></script>
    <script src="{{asset('assets/website/js/shop_custom.js') }}"></script>

@endsection