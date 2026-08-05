@extends('layouts.dashboard.dashboard')

@section('title', 'All Products')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatable.css') }}">
@endsection


@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Products</span>
        </nav>

        <div class="sl-pagebody m-4">

            {{-- Top Actions --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div class="d-flex">

                    <a href="{{ route('products.create') }}" class="btn btn-primary mr-2">

                        <i class="fa fa-plus"></i>
                        Add Product

                    </a>

                    <a href="{{ route('products.export') }}" class="btn btn-success mr-2">

                        <i class="fa fa-file-excel"></i>
                        Export Products

                    </a>

                    <a href="{{ route('products.template.download') }}" class="btn btn-outline-secondary">

                        <i class="fa fa-download"></i>
                        Download Template

                    </a>

                </div>

            </div>

            {{-- Display Import Errors --}}
            @if(session('import_failures'))

                <div class="alert alert-danger">

                    <h6>
                        Import Errors
                    </h6>

                    <ul class="mb-0">

                        @foreach(session('import_failures') as $failure)

                            <li>

                                Row {{ $failure->row() }}

                                :

                                {{ implode(', ', $failure->errors()) }}

                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif




            {{-- Import Products --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body">

                    <h6 class="font-weight-bold mb-2">
                        Import Products From Excel
                    </h6>

                    <p class="text-muted mb-3">
                        Upload an Excel file to create multiple products at once.
                    </p>

                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="row align-items-center">

                            <div class="col-md-8">

                                <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control">

                                <div class="mt-3">

                                    <small class="text-muted d-block mb-2">
                                        Required Columns
                                    </small>

                                    <span class="badge badge-secondary mr-1">
                                        category
                                    </span>

                                    <span class="badge badge-secondary mr-1">
                                        name
                                    </span>

                                    <span class="badge badge-secondary mr-1">
                                        price
                                    </span>

                                    <span class="badge badge-secondary mr-1">
                                        quantity
                                    </span>

                                </div>

                            </div>

                            <div class="col-md-4 text-md-right mt-3 mt-md-0">

                                <button type="submit" class="btn btn-info" style="cursor:pointer;">

                                    <i class="fa fa-upload"></i>
                                    Import Products

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            {{-- Products Table --}}
            <table id="productTable" class="table table-hover table-bordered">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Is Featured</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Base Price</th>
                        <th>Discount</th>
                        <th>Final Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody></tbody>

            </table>

        </div>
    </div>
    <!-- ########## END: MAIN PANEL ########## -->

@endsection


@section('js')

    {{-- DataTables Show Products data --}}
    <script>
        let table = new DataTable('#productTable', {
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            // order: [[2, 'asc']],    //ترتيب العمود التاني  تصاعدي 
            columns: [
                // { data: 'id', name: 'id', orderable: true },
                { data: 'name', name: 'name', orderable: true },
                { data: 'category', name: 'category', orderable: true },
                { data: 'description', name: 'description', orderable: true },
                { data: 'featured_status', name: 'is_featured', orderable: true },
                { data: 'quantity', name: 'quantity', orderable: true },
                { data: 'image', name: 'image', orderable: true },
                { data: 'base_price', name: 'base_price', orderable: true },
                { data: 'discount_value', name: 'discount_value', orderable: true },
                { data: 'final_price', name: 'final_price', orderable: true },
                { data: 'action', name: 'action', orderable: false, searchable: true }
            ]
        });
    </script>




    {{-- {{ Delete }} --}}
    <script>

        $(document).on('click', '.delete-product', function (e) {
            e.preventDefault();

            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: `/products/${id}`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },

                        success: function (response) {
                            let table = $('#productTable').DataTable();
                            if (response.status === 'success') {
                                Swal.fire('Deleted!', '', 'success');

                                table.ajax.reload(null, false); // بدون refresh الصفحة
                            }
                        }
                    })
                }
            })

        });

    </script>




@endsection