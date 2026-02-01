@extends('auth.master')

@section('title', 'Login')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"> <span class="tx-info tx-normal">Login</span></div>
            <div class="tx-center mg-b-60">You can login here</div>

            {{-- <form action=""> --}}
                {{-- @csrf --}}
                {{-- @method('post') --}}
                <!-- form-group -->
                <div class="form-group">
                    <input type="text" id="email" class="form-control" placeholder="Enter your Email">
                </div>
                <!-- form-group -->
                <div class="form-group">
                    <input type="password" id="password" class="form-control" placeholder="Enter your password">
                    <a href="" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
                </div>
                {{--
            </form> --}}
            <button type="submit" class="btn btn-info btn-block loginBtn" style="cursor:pointer;">Sign In</button>

            <div class="mg-t-60 tx-center">Not yet a member? <a href="{{ route('register') }}" class="tx-info">Sign
                    Up</a>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>
        $(document).ready(function () {
            $('.loginBtn').click(function (e) {
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
                        url: "/user/login",
                        data: {
                            email: email,
                            password: password,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        // dataType: 'json',
                        success: function (response) {
                            console.log(response)
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