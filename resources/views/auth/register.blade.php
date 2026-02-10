@extends('auth.master')

@section('title', 'Register')



@section('content')

    <style>
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .password-toggle:hover {
            color: #17a2b8;
            /* لون info */
        }
    </style>

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">

        <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-35 bg-white">
            <div class="logo text-center">
                <a href="{{ route('home') }}" style=" font-size: 36px;font-weight: 500;color: #0e8ce4;">OneTech</a>
            </div>
            <div class="text-center p-2">Create New Account</div>

            <form id="registerForm" name="registerForm" method="POST" action="{{ route('register') }}" autocomplete="on">
                @csrf
                <!-- form-group -->
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name"
                        autocomplete="name">
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Your Email"
                        autocomplete="email">
                </div>
                <!-- form-group -->
                <div class="form-group position-relative">
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" autocomplete="new-password">
                    <i class="fa fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
                </div>
                <!-- form-group -->
                <div class="form-group position-relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        placeholder="Enter your password again" autocomplete="new-password">
                    <i class="fa fa-eye password-toggle" onclick="togglePassword('password_confirmation', this)"></i>
                </div>
                <!-- form-group -->
                {{-- <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter your fullname">
                </div> --}}
                <!-- form-group -->
                {{-- <div class="form-group">
                    <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Birthday</label>
                    <div class="row row-xs">
                        <div class="col-sm-4">
                            <select class="form-control select2" data-placeholder="Month">
                                <option label="Month"></option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                            </select>
                        </div><!-- col-4 -->
                        <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                            <select class="form-control select2" data-placeholder="Day">
                                <option label="Day"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div><!-- col-4 -->
                        <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                            <select class="form-control select2" data-placeholder="Year">
                                <option label="Year"></option>
                                <option value="1">2010</option>
                                <option value="2">2011</option>
                                <option value="3">2012</option>
                                <option value="4">2013</option>
                                <option value="5">2014</option>
                            </select>
                        </div><!-- col-4 -->
                    </div><!-- row -->
                </div> --}}
                <!-- form-group -->
                <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and
                    terms of use of our website.</div>
                <button type="submit" class="btn btn-info btn-block" style="cursor: pointer">Sign Up</button>
            </form>
            <div class="mg-t-40 tx-center">Already have an account? <a href="{{ route('login') }}" class="tx-info">Sign
                    In</a></div>
        </div><!-- login-wrapper -->
    </div>
    <!-- d-flex -->

@endsection


@section('js')


    <script>
        $(document).ready(function () {
            $('#registerForm').on('submit', function (e) {
                e.preventDefault();

                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let password_confirmation = $('#password_confirmation').val();

                if (name == '' || email == '' || password == '' || password_confirmation == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Fill All Inputs',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    })
                } else if (password != password_confirmation) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password Does Not Match',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        url: "/register",
                        data: {
                            name: name,
                            email: email,
                            password: password,
                            password_confirmation: password_confirmation,
                            _token: "{{ csrf_token() }}",
                        },
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