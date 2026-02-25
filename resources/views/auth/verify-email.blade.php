@extends('auth.master')

@section('title', 'Email Verification')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-350 wd-xs-400 pd-25 pd-xs-40 bg-white text-center">

            <div class="logo mb-4">
                <a href="{{ route('home') }}" style="font-size:36px;font-weight:500;color:#0e8ce4;text-decoration:none;">
                    OneTech
                </a>
            </div>

            <div class="mb-4 tx-15 text-muted">
                {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mb-4">
                    {{ __('A new verification link has been sent to your email.') }}
                </div>
            @endif


            <!-- Resend Verification -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit" class="btn btn-info btn-block mb-3">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>


            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-outline-secondary btn-block">
                    {{ __('Log Out') }}
                </button>
            </form>

        </div>

    </div>

@endsection