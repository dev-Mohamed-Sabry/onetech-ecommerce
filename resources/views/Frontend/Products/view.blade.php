@extends('layouts.frontend.frontend')


@section('title', 'Product Details')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/product_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/product_responsive.css') }}">

@endsection




@section('content')
    <!-- Single Product -->

    <div class="single_product">
        <div class="container">
            <div class="row">

                <!-- Selected Image -->
                <div class="col-lg-5 order-lg-2 order-1">
                    <div class="image_selected">
                        @if ($product->image)
                            <img src="{{ $product->image }}">
                        @else
                            <img src="/uploads/products/no_img.jpg">
                        @endif
                    </div>

                </div>

                <!-- Description -->
                <div class="col-lg-5 order-3">

                    <div class="product_description">

                        <div class="product_category">{{ $product->category->name ?? "no"}}</div>

                        <div class="product_name">{{ $product->name }}</div><!-- Featured -->
                        <div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>

                        <div class="product_text ">
                            <h5>Description:</h5>
                            <p>{!!   $product->description  !!}</p>
                        </div>



                        <div class="order_info d-flex flex-row">
                            <form action="#">
                                <div class="clearfix" style="z-index: 1000;">

                                    <!-- Product Quantity -->
                                    <div class="product_quantity clearfix">
                                        <span>Quantity: </span>
                                        <input id="quantity_input" type="number" pattern="[0-9]*" value="1">
                                        <div class="quantity_buttons">
                                            <div id="quantity_inc_button" class="quantity_inc quantity_control"><i
                                                    class="fas fa-chevron-up"></i></div>
                                            <div id="quantity_dec_button" class="quantity_dec quantity_control"><i
                                                    class="fas fa-chevron-down"></i></div>
                                        </div>
                                    </div>


                                    <!-- Product Color -->
                                    {{-- <ul class="product_color">
                                        <li>
                                            <span>Color: </span>
                                            <div class="color_mark_container">
                                                <div id="selected_color" class="color_mark"></div>
                                            </div>
                                            <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i>
                                            </div>

                                            <ul class="color_list">
                                                <li>
                                                    <div class="color_mark" style="background: #999999;"></div>
                                                </li>
                                                <li>
                                                    <div class="color_mark" style="background: #b19c83;"></div>
                                                </li>
                                                <li>
                                                    <div class="color_mark" style="background: #000000;"></div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul> --}}


                                    <div class="product_price m-0">
                                        <div>Price:</div>
                                        @if($product->discount_value > 0)
                                            <span class="text-danger"
                                                style="text-decoration: line-through;">{{ $product->base_price }} EGP</span>
                                        @endif
                                        <h5 style="color: #0e8ce4;">{{$product->final_price}} EGP</h5>
                                    </div>
                                </div>
                                <div class="button_container">
                                    <button type="button" id="cart_button" class="button cart_button"
                                        data-product-id="{{ $product->id }}">
                                        Add to Cart
                                    </button>
                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                </div>

                            </form>
                        </div>
                    </div>
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
                                        ? asset($recent->product->image)
                                        : asset('uploads/products/no_img.jpg') }}" alt="{{ $product->name }}">

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
                                        src="{{ asset('assets/website/images/brands_1.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_2.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_3.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_4.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_5.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_6.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_7.jpg') }}" alt=""></div>
                            </div>
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center"><img
                                        src="{{ asset('assets/website/images/brands_8.jpg') }}" alt=""></div>
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





@section('script')

    <script src="{{ asset('assets/website/js/product_custom.js') }}"></script>

    <script>
        $(document).on('click', '#cart_button', function (e) {

            e.preventDefault();
            let product_id = $(this).data('product-id');
            let quantity = parseInt($("#quantity_input").val()) || 1;
            if (quantity < 1) {
                quantity = 1;
            }

            // console.log(quantity);
            // console.log('ADD TO CART CLICKED');

            $.ajax({
                url: '/cart/add',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    product_id: product_id,
                    quantity: quantity,
                },
                success: function (response) {
                    Swal.mixin({
                        toast: true,
                        position: "top-right",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                    }).fire({
                        icon: "success",
                        title: response.message ?? "Item Added To Cart Successfully",
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })

        })
    </script>
@endsection