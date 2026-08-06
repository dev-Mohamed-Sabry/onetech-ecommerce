@extends('layouts.dashboard.dashboard')

@section('title', 'Edit Category')

{{-- Quill Editor --}}
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endsection

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="#">Dashboard</a>
            <span class="breadcrumb-item active">Edit Category</span>
        </nav>

        <div class="sl-pagebody">
            <div class="row row-sm mt-4">
                <div class="col-xl-12">

                    <form id="categoryForm" data-id="{{ $category->id }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                            <h6 class="card-body-title mb-4">Edit Category</h6>

                            {{-- <!-- Category -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Category</label>
                                <div class="col-sm-8">
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->category_id == $category->id ?
                                            'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <!-- Name -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Category Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ $category->name }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">
                                    Category Order
                                </label>

                                <div class="col-sm-8">
                                    <input type="number" id="order" name="order" class="form-control"
                                        value="{{ $category->order }}">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Category Image</label>
                                <div class="col-sm-8">

                                    <!-- Preview -->



                                    <img id="category-image-preview" class="mb-3"
                                        src="{{ $category->image ? asset('uploads/categories/' . $category->image) : asset('uploads/categories/no_img.jpg') }}"
                                        width="120" height="120" style="object-fit:cover;border-radius:8px;">

                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="form-layout-footer">
                                <button type="submit" style="cursor: pointer;" class="btn btn-info ">Update
                                    Category</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

{{-- JS --}}
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    {{-- ================= QUILL ================= --}}
    <script>
        let quill = new Quill('#description', {
            theme: 'snow'
        });

        // ================= SET DESCRIPTION =================
        $('#productForm').on('submit', function () {
            $('#description').val(quill.root.innerHTML);
        });



        // ================= IMAGE PREVIEW =================
        $('#imageInput').on('change', function () {
            let file = this.files[0];
            if (file) {
                $('#imagePreview').attr('src', URL.createObjectURL(file));
            }
        });

        // ================= DISCOUNT TOGGLE =================
        function toggleDiscount() {
            let type = $('#discount_type').val();
            if (type === 'none') {
                $('#discount_value_row').hide();
            } else {
                $('#discount_value_row').show();
            }
        }

        toggleDiscount();

        $('#discount_type').on('change', function () {
            toggleDiscount();
        });

    </script>


    {{-- Update method --}}

    <script>
        $(document).ready(function () {

            $('#categoryForm').on('submit', function (e) {

                e.preventDefault();

                let id = $(this).data('id');

                let categoryName = $('#name').val();
                let categoryOrder = $('#order').val();
                let categoryImage = $('#image')[0].files[0];

                // ================= VALIDATION =================

                if (
                    categoryName.trim() === '' ||
                    categoryOrder === ''
                ) {

                    Swal.fire({
                        title: 'Error!',
                        text: 'Name & Order Are Required',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    });

                    return;
                }

                // ================= FORM DATA =================

                let formData = new FormData();

                formData.append('name', categoryName);
                formData.append('order', categoryOrder);

                if (categoryImage) {
                    formData.append('image', categoryImage);
                }

                formData.append('_method', 'PUT');

                // ================= AJAX =================

                $.ajax({

                    method: "POST",

                    url: `/categories/${id}`,

                    data: formData,

                    processData: false,

                    contentType: false,

                    headers: {
                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]').attr('content'),
                    },

                    success: function (response) {

                        if (!response.data) {

                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error'
                            });

                            return;
                        }

                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });

                        Toast.fire({
                            icon: "success",
                            title: "Category Updated Successfully"
                        });

                        setTimeout(() => {

                            window.location.href =
                                "{{ route('categories.index') }}";

                        }, 1500);
                    },

                    error: function (xhr) {

                        let message = 'Something went wrong!';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            message = Object.values(
                                xhr.responseJSON.errors
                            )
                                .flat()
                                .join('<br>');
                        }

                        Swal.fire({
                            title: 'Validation Error',
                            html: message,
                            icon: 'error'
                        });
                    }
                });
            });
        });

    </script>


    {{-- Delete Product Image --}}
    <script>
        $(document).on('click', '#delete-image-btn', function () {

            let id = $('#productForm').data('id');

            Swal.fire({
                title: "Delete image?",
                icon: "warning",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'DELETE',
                        url: `/products/${id}/image`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (res) {

                            if (res.status === 'success') {

                                // 🔥 تحديث الصورة فوراً بدون refresh
                                $('#product-image-preview').attr('src', '/uploads/products/no_img.jpg');

                                Swal.fire('Deleted!', '', 'success');
                            }
                        }
                    });

                }
            });

        });
    </script>
@endsection