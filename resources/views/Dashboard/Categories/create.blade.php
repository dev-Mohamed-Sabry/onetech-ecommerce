@extends('layouts.dashboard.dashboard')

@section('title', 'Add Category')

@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Add Category</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <h6 class="card-body-title mb-4">Add New Category</h6>
                        {{-- <p class="mg-b-20 mg-sm-b-30">A basic form where labels are aligned in left.</p> --}}

                        <form id="categoryForm" method="POST">
                            @csrf
                            <div class="row">
                                <label class="col-sm-4 form-control-label">Category Name: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="text" name="category-name" id="category-name" class="form-control"
                                        placeholder="Enter Category Name">
                                </div>
                            </div><!-- row -->

                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label">Category Order: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="text" name="category-order" id="category-order" class="form-control"
                                        placeholder="Enter Category Order">
                                </div>
                            </div>
                            <div class="form-layout-footer mg-t-30">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary mg-r-5"
                                    style="cursor: pointer;">All Categories</a>
                                <button type="submit" class="btn btn-info mg-r-5" style="cursor: pointer;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- sl-pagebody -->


    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection

@section('js')


    <script>
        $(document).ready(function () {
            $('#categoryForm').on('submit', function (e) {
                e.preventDefault();
                // console.log('test');
                let categoryName = $('#category-name').val();
                let categoryOrder = $('#category-order').val();
                if (categoryName == '' || categoryOrder == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Name & Order',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    })
                }
                else {
                    $.ajax({
                        method: "POST",
                        url: "{{ route('categories.store') }}",
                        data: {
                            name: categoryName,
                            order: categoryOrder,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            console.log(response);
                            if (!response.data) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                })
                            }
                            else if (response.data) {

                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: "Category Added Successfully"
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);


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
        })
    </script>

@endsection