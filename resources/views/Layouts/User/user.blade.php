<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My Profile')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/styles/bootstrap4/bootstrap.min.css') }}">


    @yield('css')
</head>




<body>

    <nav class="account-navbar">

        <div class="account-nav-left">

            <a href="{{ route('home') }}" class="nav-brand brand">
                OneTech
            </a>

        </div>

        <div class="account-nav-right">

            <a href="{{ route('home') }}" class="nav-link-item">
                Home
            </a>

            <a href="{{ route('cart.view') }}" class="nav-link-item">
                Cart
            </a>

            {{-- <a href="/my-orders" class="nav-link-item">
                Orders
            </a> --}}



            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf

                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>

        </div>

    </nav>

    @yield('content')


    <footer class="account-footer">

        <div class="footer-content">

            <div class="footer-left">
                © {{ date('Y') }} OneTech Store
            </div>

            <div class="footer-center">
                Thank you for shopping with us ♥
            </div>

            <div class="footer-right">

                <a href="#">
                    Privacy Policy
                </a>

                <a href="#">
                    Terms
                </a>

                <a href="{{ route('contact') }}">
                    Contact
                </a>

            </div>

        </div>

    </footer>

</body>

</html>