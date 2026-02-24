@extends('auth.master')

@section('title', 'Forgot Password')

@section('content')

    <style>
        .password-toggle {
            position: absolute;
            top: 30%;
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

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="logo text-center">
                <a href="{{ route('home') }} "
                    style=" font-size: 36px; font-weight: 500; color: #0e8ce4; text-decoration: none;">OneTech</a>
            </div>
            <div class="text-center pt-2 pb-4">Forgot Password</div>

            <form id="forgotPasswordForm" name="forgotPasswordForm" autocomplete="on">
                @csrf
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your Email"
                        autocomplete="email">
                </div>

                <button type="submit" id="submitButton" class="btn btn-info btn-block loginBtn" style="cursor:pointer;">Send
                    Reset
                    Link</button>

                <div class="mg-t-60 tx-center">Not yet a member? <a href="{{ route('register') }}" class="tx-info">Sign
                        Up</a>
                </div>
            </form>

        </div>
    </div>

@endsection


@section('js')

    {{-- Login Ajax Login --}}

    <script>
        $(document).ready(function () {
            $('#forgotPasswordForm').one('submit', function (e) {
                document.getElementById('submitButton').disabled = true;
                e.preventDefault();
                let email = $('#email').val();
                // console.log(email);

                if (email == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Your E-mail',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    })
                } else {
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('user.reset.password') }}",
                        data: {
                            email: email,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            // console.log(response.data);

                            if (!response.data) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This Email Does Not Exist',
                                    icon: 'error',
                                    confirmButtonText: 'Okay!'
                                })
                            } else {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Reset Link Has Been Sent To Your Email :)',
                                    icon: 'success',
                                    confirmButtonText: 'Okay!'
                                })
                            }
                            // console.log(response);

                        },
                        error: function (xhr) {
                            console.log(xhr.responseJSON);
                        }
                    })
                }
            })
        });
    </script>

@endsection