@extends('auth.master')

@section('title', 'Update Password')

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

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="logo text-center">
                <a href="#" style=" font-size: 36px; font-weight: 500; color: #0e8ce4; text-decoration: none;">OneTech</a>
            </div>
            <div class="text-center pt-2 pb-4">Reset Password</div>

            <form id="updatePasswordForm" name="updatePasswordForm" autocomplete="off" method="POST"
                action="{{ route('user.store.password', $id) }}">
                @csrf
                <!-- form-group -->
                <div class="form-group position-relative mt-4">
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter new password" autocomplete="off">
                    <i class="fa fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
                </div>
                <!-- form-group -->
                <div class="form-group position-relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        placeholder="Enter new password again" autocomplete="off">
                    <i class="fa fa-eye password-toggle" onclick="togglePassword('password_confirmation', this)"></i>
                </div>

                {{-- <div>
                    <input type="hidden" id="userId" value="{{ $id }}">
                </div> --}}
                <div class="mt-5 ">
                    <button type="submit" id="submitButton" class="btn btn-info btn-block loginBtn"
                        style="cursor:pointer;">Update Password</button>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('js')

    {{-- Update Password Ajax Login --}}
    <script>
        $(document).ready(function () {
            $('#updatePasswordForm').on('submit', function (e) {
                e.preventDefault();

                let password = $('#password').val();
                let password_confirmation = $('#password_confirmation').val();

                if (password == '' || password_confirmation == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Fill All Fields',
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
                }
                else {
                    $.ajax({
                        method: 'post',
                        url: $('#updatePasswordForm').attr('action'),
                        data: {
                            password: password,
                            password_confirmation: password_confirmation,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            // console.log(response);
                            if (!response.status) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                })
                            }
                            else if (response.status) {

                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3500,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: "Password Updated Successfully! \n Redirecting To Login Page"
                                });

                                setTimeout(() => {
                                    window.location.href = "{{ route('login') }}";
                                }, 3500);

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