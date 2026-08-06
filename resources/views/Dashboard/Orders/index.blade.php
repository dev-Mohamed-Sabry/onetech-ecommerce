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


    </div>
    <!-- ########## END: MAIN PANEL ########## -->

@endsection


@section('js')
    <script src="{{ asset('assets/dashboard/js/order.js') }}"></script>
@endsection