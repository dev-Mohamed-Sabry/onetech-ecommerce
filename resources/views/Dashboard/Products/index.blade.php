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

        <div class=" sl-pagebody m-4">

            <a href="{{ route('products.create') }}" class="btn btn-primary mb-4">
                Add New Product
            </a>

            <div class="card pd-20 pd-sm-40 form-layout form-layout-4 mt-4">
                <h6 class="card-body-title mb-4">
                    Import Products From Excel
                </h6>
                <p class="mg-b-20 text-muted">
                    Upload an Excel or CSV file to create multiple products at once.
                </p>

                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-4 form-control-label">
                            Excel File:
                            <span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control">
                            <small class="text-muted d-block mt-2">
                                Supported formats:
                                XLSX, XLS, CSV
                            </small>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <label class="col-sm-4 form-control-label">
                            Template:
                        </label>

                        <div class="col-sm-8">

                            <a href="{{ route('products.template.download') }}" class="btn btn-outline-secondary btn-sm">

                                <i class="fa fa-download"></i>
                                Download Template

                            </a>

                        </div>

                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Required Columns:</strong>
                        <br>
                        category,
                        name,
                        price,
                        quantity,
                        description,
                        featured,
                    </div>

                    <div class="form-layout-footer">
                        <button type="submit" class="btn btn-success" style="cursor: pointer;">
                            <i class="fa fa-upload"></i>
                            Import Products
                        </button>
                    </div>

                </form>

            </div>


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
                <tbody>

                </tbody>

            </table>

        </div>
        <!-- sl-pagebody -->

    </div><!-- sl-mainpanel -->
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