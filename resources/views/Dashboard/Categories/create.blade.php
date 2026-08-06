@extends('layouts.dashboard.dashboard')

@section('title', 'Add Category')

@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="#">Dashboard</a>
            <span class="breadcrumb-item active">Add Category</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <h6 class="card-body-title mb-4">Add New Category</h6>
                        {{-- <p class="mg-b-20 mg-sm-b-30">A basic form where labels are aligned in left.</p> --}}

                        <form id="categoryForm" method="POST" enctype="multipart/form-data">
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
                                    <input type="number" name="category-order" id="category-order" class="form-control"
                                        placeholder="Enter Category Order">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label">
                                    Category Image:
                                </label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input name="image" id="image" type="file" accept=".jpg,.jpeg,.png,.webp"
                                        class="form-control">
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

        {{-- <footer class="sl-footer">
            <div class="footer-left">
                <div class="copyright_content">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | Project Developed By <a href="https://www.linkedin.com/in/mo-sabre"
                        target="_blank">Eng/
                        Mohamed Sabry </a>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
            <div class="footer-right d-flex align-items-center">
                <span class="tx-uppercase mg-r-10">Share:</span>
                <a target="_blank" class="pd-x-5"
                    href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/starlight"><i
                        class="fa fa-facebook tx-20"></i></a>
                <a target="_blank" class="pd-x-5"
                    href="https://twitter.com/home?status=Starlight,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/starlight"><i
                        class="fa fa-twitter tx-20"></i></a>
            </div>
        </footer> --}}
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->



@endsection

@section('js')

    {{-- Create Category Methodz --}}
    <script>
        $(document).ready(function () {
            $('#categoryForm').on('submit', function (e) {
                e.preventDefault();

                let categoryName = $('#category-name').val();
                let categoryOrder = $('#category-order').val();
                let categoryImage = $('#image')[0].files[0];

                let formData = new FormData();
                formData.append('name', categoryName);
                formData.append('order', categoryOrder);

                if (categoryImage) {
                    formData.append('image', categoryImage);
                }

                if (!categoryName.trim() || !categoryOrder) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Name & Order Are Required',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    })
                }
                else {
                    $.ajax({
                        method: "POST",
                        url: "{{ route('categories.store') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            // console.log(response.data);

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
                            // console.log(xhr);
                            Swal.fire({
                                title: 'Error!',
                                text:
                                    'Something went wrong!',
                                icon: 'error'
                            });
                        }
                    })
                }
            })
        })
    </script>

@endsection