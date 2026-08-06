@extends('layouts.dashboard.dashboard')

@section('title', 'All Orders')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/order.css') }}">

@endsection



@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="#">Dashboard</a>
            <span class="breadcrumb-item active">Orders</span>
        </nav>


        <div class=" sl-pagebody m-4">

            <a href="{{ route('products.create') }}" class="btn btn-primary mb-4">
                Add New Product
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-success mx-2 mb-4">
                <i class="fa fa-file-excel"></i>
                Import Products
            </a>

            <table id="orderTable" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Order Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
        <!-- sl-pagebody -->

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
    <script src="{{ asset('assets/dashboard/js/order.js') }}"></script>
@endsection