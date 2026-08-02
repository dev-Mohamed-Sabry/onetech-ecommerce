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
                                <div class="top_bar_icon">
                                    <img src="{{ asset('assets/website/images/phone.png') }}" alt="">
                                </div>
                                <a href="https://wa.me/+201012537622" target="_blank">+20 1012537622</a>
                            </div>

                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon">
                                    <img src="{{ asset('assets/website/images/mail.png') }}" alt="">
                                </div>
                                <a href="mailto:mo7ammed.sabre@gmail.com">
                                    info@onetech.com
                                </a>
                            </div>

                            <div class="top_bar_content ml-auto">

                                <div class="top_bar_menu">
                                    <ul class="standard_dropdown top_bar_dropdown">
                                        <li>
                                            <a href="#">
                                                {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                                                {{-- <i class="fas fa-chevron-down">ss</i> --}}
                                            </a>
                                            <ul>
                                                @if(app()->getLocale() == 'en')
                                                    <li>
                                                        <a href="{{ route('language.switch', 'ar') }}">
                                                            العربية
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ route('language.switch', 'en') }}">
                                                            English
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>

                                        </li>

                                    </ul>
                                </div>

                                <div class="top_bar_user">

                                    <div class="user_icon">
                                        <img src="{{ asset('assets/website/images/user.svg') }}" alt="">
                                    </div>

                                    @if (Auth::check())

                                        <div>
                                            <a href="{{ route('account.index') }}">
                                                {{ __('messages.my_account') }}
                                            </a>
                                        </div>

                                        <div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" style="border:none;cursor:pointer;background:none;">
                                                    {{ __('messages.logout') }}
                                                </button>

                                            </form>
                                        </div>

                                    @else

                                        <div>
                                            <a href="{{ route('register') }}">
                                                {{ __('messages.register') }}
                                            </a>
                                        </div>

                                        <div>
                                            <a href="{{ route('login') }}">
                                                {{ __('messages.login') }}
                                            </a>
                                        </div>

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
                                                placeholder="{{ __('messages.search_products') }}">

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
                                                <a href="#">
                                                    {{ __('messages.wishlist') }}
                                                </a>
                                            </div>

                                            <div class="wishlist_count" id="wishlist-count">
                                                0
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Mini Wishlist -->
                                    <div class="mini_wishlist shadow" id="miniWishlist">

                                        <div class="mini_wishlist_header">
                                            <span>{{ __('messages.wishlist') }}</span>
                                        </div>

                                        <div class="mini_wishlist_body" id="wishlist-items">

                                            <div class="empty_wishlist">
                                                {{ __('messages.wishlist_empty') }}
                                            </div>

                                        </div>

                                        <div class="mini_wishlist_footer">

                                            <div class="wishlist_count_text">
                                                {{ __('messages.items') }}:
                                                <span id="wishlist-footer-count">0</span>
                                            </div>

                                            <div class="wishlist_count_text">
                                                {{ __('messages.total') }}:
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
                                                <a href="">
                                                    {{ __('messages.cart') }}
                                                </a>
                                            </div>

                                            <div class="cart_price" id="cart-total">
                                                0 EGP
                                            </div>

                                        </div>

                                    </div>

                                    <!-- Mini Cart -->
                                    <div class="mini_cart shadow" id="miniCart">

                                        <div class="mini_cart_header">
                                            <span>{{ __('messages.shopping_cart') }}</span>
                                        </div>

                                        <div class="mini_cart_body" id="mini-cart-items">

                                            <div class="empty_cart">
                                                {{ __('messages.cart_empty') }}
                                            </div>

                                        </div>

                                        <div class="mini_cart_footer">

                                            <div class="mini_cart_total">
                                                {{ __('messages.total') }}:
                                                <span id="mini-cart-total">0 EGP</span>
                                            </div>

                                            <div class="mini_cart_actions">

                                                <a href="{{ route('cart.view') }}" class="btn_view_cart">
                                                    {{ __('messages.view_cart') }}
                                                </a>

                                                <a href="{{ route('checkout') }}" id="checkout-btn"
                                                    class="btn_checkout">
                                                    {{ __('messages.checkout') }}
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

                                    <div
                                        class="cat_menu_title d-flex flex-row align-items-center justify-content-start">

                                        <div class="cat_burger">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>

                                        <div class="cat_menu_text">
                                            {{ __('messages.categories') }}
                                        </div>

                                    </div>

                                    <ul class="cat_menu">

                                        @forelse ($categories as $category)

                                            <li>
                                                <a class="clc" href="{{ route('products.by.category', $category) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>

                                        @empty

                                            <li class="text-danger">
                                                {{ __('messages.no_categories_found') }}
                                            </li>

                                        @endforelse

                                    </ul>

                                </div>

                                <!-- Main Nav Menu -->

                                <div class="main_nav_menu ml-auto">

                                    <ul class="standard_dropdown main_nav_dropdown">

                                        <li>
                                            <a href="{{ route('home') }}">
                                                {{ __('messages.home') }}
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a
                                                href="{{ route('products.by.category', App\Models\Product::first()?->id ?? 'No products') }}">
                                                {{ __('messages.products') }}
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('blog') }}">
                                                {{ __('messages.blog') }}
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('contact') }}">
                                                {{ __('messages.contact') }}
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        </li>

                                    </ul>

                                </div>

                                <!-- Menu Trigger -->

                                <div class="menu_trigger_container ml-auto">

                                    <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">

                                        <div class="menu_burger">

                                            <div class="menu_trigger_text">
                                                {{ __('messages.menu') }}
                                            </div>

                                            <div class="cat_burger menu_burger_inner">
                                                <span></span>
                                                <span></span>
                                                <span></span>
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
                                        <input type="search" required class="page_menu_search_input"
                                            placeholder="{{ __('messages.search_products') }}">
                                    </form>
                                </div>

                                <ul class="page_menu_nav">

                                    <li class="page_menu_item">
                                        <a href="{{ route('home') }}">
                                            {{ __('messages.home') }}
                                        </a>
                                    </li>

                                    <li class="page_menu_item">
                                        <a href="{{ route('products.index') }}">
                                            {{ __('messages.products') }}
                                        </a>
                                    </li>

                                    <li class="page_menu_item">
                                        <a href="{{ route('blog') }}">
                                            {{ __('messages.blog') }}
                                        </a>
                                    </li>

                                    <li class="page_menu_item">
                                        <a href="{{ route('contact') }}">
                                            {{ __('messages.contact') }}
                                        </a>
                                    </li>

                                    @auth
                                        <li class="page_menu_item">
                                            <a href="{{ route('account.index') }}">
                                                {{ __('messages.my_account') }}
                                            </a>
                                        </li>

                                        <li class="page_menu_item">
                                            <a href="{{ route('cart.view') }}">
                                                {{ __('messages.cart') }}
                                            </a>
                                        </li>
                                    @endauth

                                </ul>

                                <div class="menu_contact">

                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon">
                                            <img src="{{ asset('assets/website/images/phone_white.png') }}" alt="">
                                        </div>
                                        +20 101 253 7622
                                    </div>

                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon">
                                            <img src="{{ asset('assets/website/images/mail_white.png') }}" alt="">
                                        </div>
                                        <a href="mailto:fastsales@gmail.com">
                                            fastsales@gmail.com
                                        </a>
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

                                <div class="newsletter_icon">
                                    <img src="{{ asset('assets/website/images/send.png') }}" alt="">
                                </div>

                                <div class="newsletter_title">
                                    {{ __('messages.newsletter_title') }}
                                </div>

                                <div class="newsletter_text">
                                    <p>{{ __('messages.newsletter_description') }}</p>
                                </div>

                            </div>

                            <div class="newsletter_content clearfix">

                                <form action="#" class="newsletter_form">

                                    <input type="email" class="newsletter_input" required
                                        placeholder="{{ __('messages.enter_email') }}">

                                    <button class="newsletter_button">
                                        {{ __('messages.subscribe') }}
                                    </button>

                                </form>

                                <div class="newsletter_unsubscribe_link">
                                    <a href="#">
                                        {{ __('messages.unsubscribe') }}
                                    </a>
                                </div>

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

                    <!-- Company Info -->
                    <div class="col-lg-4 footer_col">

                        <div class="footer_column footer_contact">

                            <div class="logo_container">
                                <div class="logo">
                                    <a href="{{ route('home') }}">OneTech</a>
                                </div>
                            </div>

                            <div class="footer_title">
                                {{ __('messages.got_question') }}
                            </div>

                            <div class="footer_phone">
                                +20 101 253 7622
                            </div>

                            <div class="footer_contact_text">
                                <p>support@onetech.com</p>
                                <p>Cairo, Egypt</p>
                            </div>

                        </div>

                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-3 footer_col">

                        <div class="footer_column">

                            <div class="footer_title">
                                {{ __('messages.quick_links') }}
                            </div>

                            <ul class="footer_list">

                                <li>
                                    <a href="{{ route('home') }}">
                                        {{ __('messages.home') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('products.index') }}">
                                        {{ __('messages.products') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('blog') }}">
                                        {{ __('messages.blog') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('contact') }}">
                                        {{ __('messages.contact') }}
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <!-- Customer Area -->
                    <div class="col-lg-3 footer_col">

                        <div class="footer_column">

                            <div class="footer_title">
                                {{ __('messages.customer_area') }}
                            </div>

                            <ul class="footer_list">

                                <li>
                                    <a href="{{ route('account.index') }}">
                                        {{ __('messages.my_account') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('account.index') }}">
                                        {{ __('messages.my_orders') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        {{ __('messages.wishlist') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('cart.view') }}">
                                        {{ __('messages.cart') }}
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <!-- Social -->
                    <div class="col-lg-2 footer_col">

                        <div class="footer_column">

                            <div class="footer_title">
                                {{ __('messages.follow_us') }}
                            </div>

                            <div class="footer_social">

                                <ul>

                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>

                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>

                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>

                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>

                                </ul>

                            </div>

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

                                © {{ date('Y') }}

                                OneTech.

                                {{ __('messages.copyright') }}

                                <span class="text-muted ml-2">

                                    {{ __('messages.powered_by') }}

                                    <a href="https://www.linkedin.com/in/mo-sabre" target="_blank">
                                        Mohamed Sabry
                                    </a>

                                </span>

                            </div>

                            <div class="logos ml-sm-auto">

                                <ul class="logos_list">

                                    <li>
                                        <img src="{{ asset('assets/website/images/logos_1.png') }}" alt="">
                                    </li>

                                    <li>
                                        <img src="{{ asset('assets/website/images/logos_2.png') }}" alt="">
                                    </li>

                                    <li>
                                        <img src="{{ asset('assets/website/images/logos_3.png') }}" alt="">
                                    </li>

                                    <li>
                                        <img src="{{ asset('assets/website/images/logos_4.png') }}" alt="">
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