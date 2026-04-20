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

                    <form id="productForm" method="PUT" enctype="multipart/form-data">
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
                                    @if ($product->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('uploads/products/' . $product->image) }} " width="120"
                                                height="120" id="imagePreview">
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <img src="{{ asset('uploads/products/no_img.jpg') }} " width="120" height="120"
                                                id="imagePreview">
                                        </div>
                                    @endif

                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mb-2">
                                <label class="col-sm-4 form-control-label">Description</label>
                                <div class="col-sm-8">
                                    <div id="editor" style="height: 150px;">
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

    <script>
        // ================= QUILL =================
        let quill = new Quill('#editor', {
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

                let productName = $('#name').val();
                let productBasePrice = $('#base_price').val();
                let productDiscountType = $('#discount_type').val();
                let productDescription = quill.root.innerHTML;
                let productQuantity = $('#quantity').val();
                let productDiscountValue = $('#discount_value').val();
                let productImage = $('#image')[0].files[0];



                // ================= VALIDATION =================
                if (
                    productName == '' ||
                    productBasePrice == '' ||
                    productDiscountType == '' ||
                    productDescription == '' ||
                    productQuantity == ''
                ) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'All Fields (Except Image & Description) Are Required ',
                        icon: 'error',
                        confirmButtonText: 'Okay!'
                    });
                    // return;
                }
            })
        })



        // $(document).on('click', '.edit-product', function (e) {
        //     e.preventDefault();

        //     let productName = $('#name').val();
        //     let productBasePrice = $('#base_price').val();
        //     let productDiscountType = $('#discount_type').val();
        //     let productDescription = quill.root.innerHTML;
        //     let productQuantity = $('#quantity').val();
        //     let productDiscountValue = $('#discount_value').val();
        //     let productImage = $('#image')[0].files[0];

        //     // ================= VALIDATION =================
        //     if (

        //         productName == '' ||
        //         productBasePrice == '' ||
        //         productDiscountType == '' ||
        //         productDescription == '' ||
        //         productQuantity == '' ||
        //                             ) {
        //         Swal.fire({
        //             title: 'Error!',
        //             text: 'All Fields (Except Image & Description) Are Required ',
        //             icon: 'warning',
        //             confirmButtonText: 'Okay!'
        //         });
        //         // return;
        //     }

        //     // Swal.fire({
        //     //     title: "Enter New Category Name",
        //     //     input: "text",
        //     //     inputValue: name,
        //     //     showCancelButton: true,
        //     //     confirmButtonText: "Update",
        //     //     showLoaderOnConfirm: true,
        //     //     preConfirm: (newName) => {
        //     //         return fetch(`/categories/${id}`, {
        //     //             method: "POST",
        //     //             headers: {
        //     //                 "Content-Type": "application/json",
        //     //                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //     //             },
        //     //             body: JSON.stringify({
        //     //                 _method: "PUT",
        //     //                 name: newName
        //     //             })
        //     //         })
        //     //             .then(async response => {
        //     //                 const data = await response.json();

        //     //                 if (!response.ok) {
        //     //                     let messages = Object.values(data.errors || {}).flat().join('<br>');

        //     //                     Swal.fire({
        //     //                         icon: 'error',
        //     //                         title: 'Validation Error',
        //     //                         text: messages
        //     //                     });

        //     //                     // ❌ نوقف العملية
        //     //                     return false;
        //     //                 }

        //     //                 return data;
        //     //             });
        //     //     }
        //     // }).then(result => {
        //     //     if (result.isConfirmed) {
        //     //         Swal.fire('Success', 'Updated!', 'success')
        //     //             .then(() => location.reload());
        //     //     }
        //     // });
        // });

    </script>

@endsection