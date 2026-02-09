@extends('auth.master')

@section('title', 'Login')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="logo text-center">
                <a href="{{ route('home') }} " style=" font-size: 36px; font-weight: 500; color: #0e8ce4;">OneTech</a>
            </div>
            <div class="text-center p-2">Login Form</div>

            <form id="loginForm" name="loginForm" autocomplete="on">
                @csrf
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your Email"
                        autocomplete="email">
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" autocomplete="current-password">
                    <a href="#" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-info btn-block loginBtn" style="cursor:pointer;">Sign In</button>

                <div class="mg-t-60 tx-center">Not yet a member? <a href="{{ route('register') }}" class="tx-info">Sign
                        Up</a>
                </div>
            </form>

        </div>
    </div>

@endsection


@section('js')

    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();
                let email = $('#email').val();
                let password = $('#password').val();

                if (email == '' || password == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter E-mail & Password',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        url: "/login",
                        data: {
                            email: email,
                            password: password,
                            _token: "{{ csrf_token() }}"
                        },
                        // headers: {
                        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        // },
                        // dataType: 'json',
                        success: function (response) {
                            if (!response.status) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                })
                            }
                            else if (response.status && response.role === 'admin') {

                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: "Logged In! Redirecting To Dashboard"
                                });

                                setTimeout(() => {
                                    window.location.href = '/dashboard';
                                }, 1500);

                            }

                            else if (response.status && response.role === 'user') {
                                window.location = '/';
                            }

                        },
                        error: function (xhr) {
                            console.log(xhr.responseJSON);
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON.message ?? 'Something went wrong!',
                                icon: 'error',
                                confirmButtonText: 'Okay!'
                            });
                        }
                    })
                }
            })
        });
    </script>

@endsection