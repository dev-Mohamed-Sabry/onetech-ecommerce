@extends('layouts.dashboard.dashboard')

@section('title', 'Add Product')


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

                    <form method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                            <h6 class="card-body-title mb-4">Add New Product</h6>

                            <!-- Category -->
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Category: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select name="category_id" id="category" class="form-control" required>
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
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Product Name: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input required name="name" id="name" type="text" class="form-control"
                                        placeholder="Enter product name">
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Price: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input required name="price" id="price" type="number" min="0" step="0.01"
                                        class="form-control" placeholder="Enter product price">
                                </div>
                            </div>
                            <!-- Discount -->
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Discount: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input required name="discount" id="discount" type="number" class="form-control"
                                        placeholder="Enter product discount">
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Quantity: <span class="tx-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input required name="quantity" id="quantity" type="number" class="form-control"
                                        placeholder="Enter quantity">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Description:
                                </label>
                                <div class="col-sm-8">
                                    <textarea required name="description" id="description" rows="3" class="form-control"
                                        placeholder="Product description"></textarea>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="row mg-b-20">
                                <label class="col-sm-4 form-control-label">
                                    Product Image:
                                </label>
                                <div class="col-sm-8">
                                    <input required name="image" id="image" type="file" accept="image/*"
                                        class="form-control">
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

        <!-- sl-pagebody -->



        <footer class="sl-footer">
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
        </footer>

    </div>
    <!-- sl-mainpanel -->

    <!-- ########## END: MAIN PANEL ########## -->
@endsection