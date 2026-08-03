@extends('layouts.dashboard.dashboard')

@section('title', 'Add Product')

{{-- Quill Editor --}}
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endsection

@section('content')



    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Add Product</span>
        </nav>


        <div class="sl-pagebody">
            <div class="row row-sm mt-4">
                <div class="col-xl-12">
                    <form method="POST" id="productForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                            <h6 class="card-body-title mb-4">Add New Product</h6>

                            <!-- Category -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Category: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option disabled selected>Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Product Name: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input name="name" id="name" type="text" class="form-control"
                                        placeholder="Enter product name">
                                </div>
                            </div>

                            <!-- Base Price -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Price: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input name="base_price" id="base_price" type="number" min="0" class="form-control"
                                        placeholder="Enter product price">
                                </div>
                            </div>

                            <!-- Discount Type-->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Discount:
                                </label>
                                <div class="col-sm-8">
                                    <select name="discount_type" id="discount_type" class="form-control">
                                        <option value="none">No Discount</option>
                                        <option value="percent">Percent %</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Discount Value-->
                            <div class="row  mb-1" id="discount_value_row">
                                <label class="col-sm-4 form-control-label">
                                    Discount Value: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input name="discount_value" id="discount_value" type="number" class="form-control">
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Quantity: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input name="quantity" id="quantity" type="number" class="form-control"
                                        placeholder="Enter quantity">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Product Image:
                                </label>
                                <div class="col-sm-8">
                                    <input name="image" id="image" type="file" accept=".jpg,.jpeg,.png,.webp"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- Is Featured -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Is Featured: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="0">🔴 No (Default)</option>
                                        <option value="1">🟢 Yes</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mb-1">
                                <label class="col-sm-4 form-control-label">
                                    Description:
                                </label>
                                {{-- <div class="col-sm-8">
                                    <textarea name="description" id="description" rows="3" class="form-control"
                                        placeholder="Product description"></textarea>
                                </div> --}}
                                <div class="col-sm-8">
                                    <div id="editor" name="description" id="description" rows="3" class="form-control "
                                        placeholder="Product description">
                                    </div>
                                </div>
                            </div>



                            <!-- Buttons -->
                            <div class="form-layout-footer">
                                <button type="submit" class="btn btn-info mg-r-5" style="cursor: pointer;">
                                    <i class="fa fa-save"></i> Save Product
                                </button>
                                <button type="reset" class="btn btn-secondary" style="cursor: pointer;">
                                    <i class=" fa fa-times"></i> Cancel
                                </button>
                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>


    </div>


    <!-- ########## END: MAIN PANEL ########## -->
@endsection


@section('js')

    {{-- Quill Editor --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>  const quill = new Quill('#editor', {
            theme: 'snow'
        });</script>

    {{-- Create Product Method --}}
    <script>
        $(document).ready(function () {
            $('#productForm').on('submit', function (e) {
                e.preventDefault();
                let categoryId = $('#category_id').val();
                let productName = $('#name').val();
                let productBasePrice = $('#base_price').val();
                let productDiscountType = $('#discount_type').val();
                let productDescription = quill.root.innerHTML;
                let productIsFeatured = $('#is_featured').val();
                let productDiscountValue = $('#discount_value').val();
                let productQuantity = $('#quantity').val();
                let productImage = $('#image')[0].files[0];

                // ================= VALIDATION =================
                if (
                    categoryId == "" ||
                    productName == '' ||
                    productBasePrice == '' ||
                    // productDiscountType !== 'none' ||
                    // productDiscountType !== 'fixed' ||
                    // productDiscountType !== 'percent' ||
                    productQuantity == '' ||
                    productDescription == '' ||
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

                formData.append('category_id', categoryId);
                formData.append('name', productName);
                formData.append('base_price', productBasePrice);
                formData.append('quantity', productQuantity);
                formData.append('description', productDescription);
                formData.append('discount_type', productDiscountType);
                formData.append('is_featured', productIsFeatured);

                if (productDiscountType !== 'none') {
                    formData.append('discount_value', productDiscountValue);
                } else {
                    formData.append('discount_value', 0);
                }

                // image optional
                if (productImage) {
                    formData.append('image', productImage);
                }
                // console.log(formData);
                console.log(productDiscountType);
                // ================= AJAX =================
                $.ajax({
                    method: "POST",
                    url: "{{ route('products.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    success: function (response) {
                        // console.log(response);

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
                                title: "Product Added Successfully"
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
                });

            });

        });
    </script>

    {{-- Hide Discount Value Field If None Selected --}}
    <script>
        $(document).ready(function () {

            function toggleDiscount() {
                if ($('#discount_type').val() === 'fixed' || $('#discount_type').val() === 'percent') {
                    $('#discount_value_row').show();
                } else {
                    $('#discount_value_row').hide();
                }
            }

            // أول تحميل
            toggleDiscount();

            // عند التغيير
            $('#discount_type').on('change', function () {
                toggleDiscount();
            });

        });
    </script>
@endsection