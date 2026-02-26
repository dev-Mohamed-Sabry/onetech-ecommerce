@extends('auth.master')

@section('title', 'Account Verified')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-350 wd-xs-400 pd-25 pd-xs-40 bg-white text-center">

            <div class="logo mb-4">
                <a href="{{ route('home') }}" style="font-size:36px;font-weight:500;color:#0e8ce4;text-decoration:none;">
                    OneTech
                </a>
            </div>

            <div class="mb-4">
                <i class="fa fa-check-circle text-success" style="font-size:60px;"></i>
            </div>

            <h5 class="mb-3 text-success">
                Your Account Has Been Verified Successfully 🎉
            </h5>

            <p class="text-muted mb-4">
                You will be redirected to the login page shortly.
            </p>

            <a href="{{ route('login') }}" class="btn btn-info btn-block">
                Go To Login
            </a>

        </div>

    </div>

    {{-- Auto Redirect --}}
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('login') }}";
        }, 3000);
    </script>

@endsection