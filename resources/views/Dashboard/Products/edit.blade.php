@extends('layouts.dashboard.dashboard')

@section('title', 'Edit Product')

{{-- Quill Editor --}}
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endsection

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Edit Product</span>
        </nav>

        <div class="sl-pagebody">
            <div class="row row-sm mt-4">
                <div class="col-xl-12">

                    <form id="productForm" data-id="{{ $product->id }}" method="PUT" enctype="multipart/form-data">
                        @csrf

                        <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                            <h6 class="card-body-title mb-4">Edit Product</h6>

                            {{-- <!-- Category -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Category</label>
                                <div class="col-sm-8">
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ?
                                            'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <!-- Name -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Product Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ $product->name }}">
                                </div>
                            </div>

                            <!-- Base Price -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Price</label>
                                <div class="col-sm-8">
                                    <input type="number" id="base_price" name="base_price" class="form-control"
                                        value="{{ $product->base_price }}">
                                </div>
                            </div>

                            <!-- Discount Type -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Discount</label>
                                <div class="col-sm-8">
                                    <select name="discount_type" id="discount_type" class="form-control">
                                        <option value="none" {{ $product->discount_type == 'none' ? 'selected' : '' }}>No
                                            Discount</option>
                                        <option value="percent" {{ $product->discount_type == 'percent' ? 'selected' : '' }}>
                                            Percent %</option>
                                        <option value="fixed" {{ $product->discount_type == 'fixed' ? 'selected' : '' }}>Fixed
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Discount Value -->
                            <div class="row mb-2" id="discount_value_row">
                                <label class="col-sm-4 form-control-label">Discount Value</label>
                                <div class="col-sm-8">
                                    <input type="number" name="discount_value" id="discount_value" class="form-control"
                                        value="{{ $product->discount_value }}">
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Quantity</label>
                                <div class="col-sm-8">
                                    <input type="number" id="quantity" name="quantity" class="form-control"
                                        value="{{ $product->quantity }}">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Product Image</label>
                                <div class="col-sm-8">

                                    <!-- Preview -->

                                    <img id="product-image-preview"
                                        src="{{ $product->image ? asset('uploads/products/' . $product->image) : asset('uploads/products/no_img.jpg') }}"
                                        width="120" height="120">

                                    @if ($product->image)
                                        <button type="button" id="delete-image-btn" class="btn btn-danger"
                                            style="border-radius:3rem; cursor: pointer;">
                                            Delete Image
                                        </button>
                                    @endif



                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>

                            <!-- Is Featured -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Is Featured: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    {{-- value="{{ $product->is_featured }}" --}}
                                    {{-- <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="0">🔴 No (Default)</option>
                                        <option value="1">🟢 Yes</option>
                                    </select> --}}
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>
                                            🔴 No (Default)
                                        </option>

                                        <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>
                                            🟢 Yes
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Description</label>
                                <div class="col-sm-8">
                                    <div id="description" style="height: 150px;">
                                        {!! $product->description !!}
                                    </div>
                                    <input type="hidden" name="description" id="description">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="form-layout-footer">
                                <button type="submit" style="cursor: pointer;" class="btn btn-info edit-product">Update
                                    Product</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
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
            $('#productForm').on('submit', function (e) {
                e.preventDefault();

                let id = $(this).data('id');
                // let categoryId = $('#category_id').val();
                let productName = $('#name').val();
                let productBasePrice = $('#base_price').val();
                let productDiscountType = $('#discount_type').val();
                let productDescription = quill.root.innerHTML;
                let productIsFeatured = $('#is_featured').val();
                let productQuantity = $('#quantity').val();
                let productDiscountValue = $('#discount_value').val();
                let productImage = $('#image')[0].files[0];


                // ================= VALIDATION =================
                // let isDescriptionEmpty = quill.getText().trim() === '';
                if (
                    productName == '' ||
                    productBasePrice == '' ||
                    productDiscountType == '' ||
                    productQuantity == '' ||
                    // isDescriptionEmpty ||
                    productIsFeatured == ''
                ) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'All Fields (Except Image & Description) Are Required ',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    });
                    return;
                }

                // ================= FORM DATA =================
                let formData = new FormData();
                // FormData.append('id', $id);
                formData.append('name', productName);
                formData.append('base_price', productBasePrice);
                formData.append('quantity', productQuantity);
                formData.append('description', productDescription);
                formData.append('is_featured', productIsFeatured);
                formData.append('discount_type', productDiscountType);
                if (productDiscountType !== 'none') {
                    formData.append('discount_value', productDiscountValue);
                } else {
                    formData.append('discount_value', 0);
                }
                // image optional
                if (productImage) {
                    formData.append('image', productImage);
                }
                // formData.append('category_id', categoryId);
                formData.append('_method', 'PUT');

                // ================= AJAX =================
                $.ajax({
                    method: "POST",
                    url: `/products/${id}`,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (!response.data) {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Ok',
                            });
                        } else {

                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true,
                            });

                            Toast.fire({
                                icon: "success",
                                title: "Updated & Redirecting To Products Page"
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('products.index') }}";
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
            })
        })

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