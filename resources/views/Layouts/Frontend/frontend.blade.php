<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/bootstrap4/bootstrap.min.css') }}">
    {{--
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/website/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}"> --}}
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/website/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/website/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/plugins/OwlCarousel2-2.2.1/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/plugins/slick-1.8.0/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/main_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/styles/cart_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/styles/wishlist.css') }}">


    @yield('css')
</head>

<body>



    <div class="super_container">

        <!-- Header -->

        <header class="header">

            <!-- Top Bar -->

            <div class="top_bar">
                <div class="container">
                    <div class="row">
                        <div class="col d-flex flex-row">
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><img src="{{ asset('assets/website/images/phone.png') }}"
                                        alt=""></div>+38 068 005 3570
                            </div>
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><img src="{{ asset('assets/website/images/mail.png') }}"
                                        alt=""></div><a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a>
                            </div>
                            <div class="top_bar_content ml-auto">
                                {{-- <div class="top_bar_menu">
                                    <ul class="standard_dropdown top_bar_dropdown">
                                        <li>
                                            <a href="#">English<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li><a href="#">Italian</a></li>
                                                <li><a href="#">Spanish</a></li>
                                                <li><a href="#">Japanese</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">$ US dollar<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li><a href="#">EUR Euro</a></li>
                                                <li><a href="#">GBP British Pound</a></li>
                                                <li><a href="#">JPY Japanese Yen</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="top_bar_user">
                                    <div class="user_icon"><img src="{{ asset('assets/website/images/user.svg') }}"
                                            alt=""></div>
                                    @if (Auth::check())

                                        <div><a href="#">My Account</a></div>
                                        <div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <button type="submit "
                                                    style="border: none; cursor: pointer; background:none;">Logout</button>
                                        </div>
                                        </form>

                                    @else
                                        <div><a href="{{route('register')}}">Register</a></div>
                                        <div><a href="{{ route('login') }}">Log in</a></div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Main -->

            <div class="header_main">
                <div class="container">
                    <div class="row">

                        <!-- Logo -->
                        <div class="col-lg-2 col-sm-3 col-3 order-1">
                            <div class="logo_container">
                                <div class="logo"><a href="{{ route('home') }}">OneTech</a></div>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                            <div class="header_search">
                                <div class="header_search_content">
                                    <div class="header_search_form_container">

                                        <form id="searchForm" method="POST" class="header_search_form clearfix">
                                            <input type="search" name="search" class="header_search_input"
                                                placeholder="Search for products...">

                                            <button type="submit" class="header_search_button trans_300"
                                                value="Submit"><img
                                                    src="{{ asset('assets/website/images/search.png') }}"
                                                    alt=""></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wishlist -->
                        <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                            <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">

                                <!-- Wishlist -->
                                <div class="wishlist_wrapper position-relative">

                                    <div class="wishlist d-flex flex-row align-items-center justify-content-end"
                                        id="wishlistToggle">

                                        <div class="wishlist_icon">
                                            <img src="{{ asset('assets/website/images/heart.png') }}" alt="">
                                        </div>

                                        <div class="wishlist_content">
                                            <div class="wishlist_text">
                                                <a href="#">Wishlist</a>
                                            </div>

                                            <div class="wishlist_count" id="wishlist-count">
                                                0
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Mini Wishlist -->
                                    <div class="mini_wishlist shadow" id="miniWishlist">
                                        <div class="mini_wishlist_header">
                                            <span>Wishlist</span>
                                        </div>
                                        <div class="mini_wishlist_body" id="wishlist-items">
                                            <div class="empty_wishlist">
                                                Your wishlist is empty
                                            </div>
                                        </div>
                                        <div class="mini_wishlist_footer">
                                            <div class="wishlist_count_text">
                                                Items:
                                                <span id="wishlist-footer-count">0</span>
                                            </div>
                                            <div class="wishlist_count_text">
                                                Total:
                                                <span id="wishlist-footer-total">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cart -->
                                <div class="cart position-relative">
                                    <div class="cart_container d-flex flex-row align-items-center justify-content-end"
                                        id="cartToggle">
                                        <div class="cart_icon position-relative">
                                            <img src="{{ asset('assets/website/images/cart.png') }}" alt="">
                                            <div class="cart_count">
                                                <span id="cart-count">0</span>
                                            </div>
                                        </div>
                                        <div class="cart_content">
                                            <div class="cart_text">
                                                <a href="">Cart</a>
                                            </div>
                                            <div class="cart_price" id="cart-total">
                                                0 EGP
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mini Cart -->
                                    <div class="mini_cart shadow" id="miniCart">
                                        <div class="mini_cart_header">
                                            <span>Shopping Cart</span>
                                        </div>
                                        <div class="mini_cart_body" id="mini-cart-items">
                                            <div class="empty_cart">
                                                Your cart is empty
                                            </div>
                                        </div>
                                        <div class="mini_cart_footer">
                                            <div class="mini_cart_total">
                                                Total:
                                                <span id="mini-cart-total">0 EGP</span>
                                            </div>
                                            <div class="mini_cart_actions">
                                                <a href="{{ route('cart.view') }}" class="btn_view_cart">
                                                    View Cart
                                                </a>
                                                <a href="{{ route('checkout') }}" id="checkout-btn"
                                                    class="btn_checkout">
                                                    Checkout
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Main Navigation -->

            <nav class="main_nav">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <div class="main_nav_content d-flex flex-row">

                                <!-- Categories Menu -->

                                <div class="cat_menu_container {{ request()->routeIs('home') ? 'home' : '' }}">
                                    <div class=" cat_menu_title d-flex flex-row align-items-center
                                    justify-content-start">
                                        <div class="cat_burger"><span></span><span></span><span></span></div>
                                        <div class="cat_menu_text">categories</div>
                                    </div>

                                    <ul class="cat_menu">
                                        @forelse ($categories as $category)
                                            <li>
                                                <a class="clc"
                                                    href="{{ route('products.by.category', $category) }}">{{ $category->name }}</a>
                                            </li>

                                        @empty
                                            <li class="text-danger">No Categories Found</li>
                                        @endforelse

                                    </ul>
                                </div>

                                <!-- Main Nav Menu -->

                                <div class="main_nav_menu ml-auto">
                                    <ul class="standard_dropdown main_nav_dropdown">
                                        <li><a href="{{ route('home') }}">Home<i class="fas fa-chevron-down"></i></a>
                                        </li>

                                        <li>
                                            <a
                                                href="{{ route('products.by.category', App\Models\Product::first()?->id ?? 'No products') }}">Products
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        </li>
                                        <li><a href="{{ route('blog') }}">Blog<i class="fas fa-chevron-down"></i></a>
                                        </li>
                                        <li><a href="{{ route('contact') }}">Contact<i
                                                    class="fas fa-chevron-down"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Menu Trigger -->

                                <div class="menu_trigger_container ml-auto">
                                    <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                        <div class="menu_burger">
                                            <div class="menu_trigger_text">menu</div>
                                            <div class="cat_burger menu_burger_inner">
                                                <span></span><span></span><span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Menu -->

            <div class="page_menu">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <div class="page_menu_content">

                                <div class="page_menu_search">
                                    <form action="#">
                                        <input type="search" required="required" class="page_menu_search_input"
                                            placeholder="Search for products...">
                                    </form>
                                </div>
                                <ul class="page_menu_nav">
                                    <li class="page_menu_item has-children">
                                        <a href="#">Language<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Italian<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Spanish<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Japanese<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Currency<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">EUR Euro<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">GBP British Pound<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">JPY Japanese Yen<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item">
                                        <a href="#">Home<i class="fa fa-angle-down"></i></a>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Super Deals<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Super Deals<i class="fa fa-angle-down"></i></a></li>
                                            <li class="page_menu_item has-children">
                                                <a href="#">Menu Item<i class="fa fa-angle-down"></i></a>
                                                <ul class="page_menu_selection">
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Trending Styles<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Trending Styles<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item"><a href="{{ route('blog') }}">blog<i
                                                class="fa fa-angle-down"></i></a></li>
                                    <li class="page_menu_item"><a href="{{ route('contact') }}">contact<i
                                                class="fa fa-angle-down"></i></a></li>
                                </ul>

                                <div class="menu_contact">
                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon"><img
                                                src="{{ asset('assets/website/images/phone_white.png') }}" alt=""></div>
                                        +20 101 253 7622
                                    </div>
                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon"><img
                                                src="{{ asset('assets/website/images/mail_white.png') }}" alt=""></div>
                                        <a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>




        @yield('content')




        <!-- Newsletter -->

        <div class="newsletter">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div
                            class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                            <div class="newsletter_title_container">
                                <div class="newsletter_icon"><img src="{{ asset('assets/website/images/send.png') }}"
                                        alt=""></div>
                                <div class="newsletter_title">Sign up for Newsletter</div>
                                <div class="newsletter_text">
                                    <p>...and receive %20 coupon for first shopping.</p>
                                </div>
                            </div>
                            <div class="newsletter_content clearfix">
                                <form action="#" class="newsletter_form">
                                    <input type="email" class="newsletter_input" required="required"
                                        placeholder="Enter your email address">
                                    <button class="newsletter_button">Subscribe</button>
                                </form>
                                <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->

        <footer class="footer">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 footer_col">
                        <div class="footer_column footer_contact">
                            <div class="logo_container">
                                <div class="logo"><a href="#">OneTech</a></div>
                            </div>
                            <div class="footer_title">Got Question? Call Us 24/7</div>
                            <div class="footer_phone">+38 068 005 3570</div>
                            <div class="footer_contact_text">
                                <p>17 Princess Road, London</p>
                                <p>Grester London NW18JR, UK</p>
                            </div>
                            <div class="footer_social">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 offset-lg-2">
                        <div class="footer_column">
                            <div class="footer_title">Find it Fast</div>
                            <ul class="footer_list">
                                <li><a href="#">Computers & Laptops</a></li>
                                <li><a href="#">Cameras & Photos</a></li>
                                <li><a href="#">Hardware</a></li>
                                <li><a href="#">Smartphones & Tablets</a></li>
                                <li><a href="#">TV & Audio</a></li>
                            </ul>
                            <div class="footer_subtitle">Gadgets</div>
                            <ul class="footer_list">
                                <li><a href="#">Car Electronics</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="footer_column">
                            <ul class="footer_list footer_list_2">
                                <li><a href="#">Video Games & Consoles</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Cameras & Photos</a></li>
                                <li><a href="#">Hardware</a></li>
                                <li><a href="#">Computers & Laptops</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="footer_column">
                            <div class="footer_title">Customer Care</div>
                            <ul class="footer_list">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Order Tracking</a></li>
                                <li><a href="#">Wish List</a></li>
                                <li><a href="#">Customer Services</a></li>
                                <li><a href="#">Returns / Exchange</a></li>
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">Product Support</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

        <!-- Copyright -->

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <div
                            class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-center">
                            <div class="copyright_content">
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | Project Developed By <a
                                    href="https://www.linkedin.com/in/mo-sabre" target="_blank">Eng/
                                    Mohamed Sabry </a>
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </div>
                            <div class="logos ml-sm-auto">
                                <ul class="logos_list">
                                    <li><a href="#"><img src="{{ asset('assets/website/images/logos_1.png') }}"
                                                alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="{{ asset('assets/website/images/logos_2.png') }}"
                                                alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="{{ asset('assets/website/images/logos_3.png') }}"
                                                alt=""></a>
                                    </li>
                                    <li><a href="#"><img src="{{ asset('assets/website/images/logos_4.png') }}"
                                                alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/website/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/website/styles/bootstrap4/popper.js') }}"></script>
    <script src="{{ asset('assets/website/styles/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/greensock/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/greensock/TimelineMax.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/greensock/animation.gsap.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/greensock/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/slick-1.8.0/slick.js') }}"></script>
    <script src="{{ asset('assets/website/plugins/easing/easing.js') }}"></script>
    <script src="{{ asset('assets/website/js/custom.js') }}"></script>
    <script src="{{ asset('assets/website/js/cart.js') }}"></script>
    <script src="{{ asset('assets/website/js/wishlist.js') }}"></script>

    @yield('script')


    <script src="{{ asset('assets/website/js/search.js') }}"></script>


    {{-- Cart Error If exists --}}
    @if(session('error'))
        <script>
            Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,

            }).fire({
                icon: "warning",
                text: "{{ session('error') }}",
            });
        </script>

    @endif


    {{-- Stock Error If exists --}}
    @if(session('message'))
        <script>
            Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,

            }).fire({
                icon: "warning",
                text: "{{ session('message') }}",
            });
        </script>

    @endif

    {{-- Order Success --}}
    @if(session('success'))
        <script>
            Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,

            }).fire({
                icon: "success",
                text: "{{ session('success') }}",
            });
        </script>

    @endif
</body>

</html>