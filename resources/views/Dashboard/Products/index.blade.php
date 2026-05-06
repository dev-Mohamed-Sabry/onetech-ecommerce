@extends('layouts.dashboard.dashboard')

@section('title', 'All Products')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endsection
<style>
    /* Start DataTables Styling */
    #myTable_wrapper {
        padding: 0 0 2rem;
    }

    .dt-input {
        margin-right: 5px;
    }

    .dt-type-numeric {
        text-align: center !important;
    }

    .table-bordered tbody tr td {
        align-content: center !important;
    }

    /* End DataTables Styling */
</style>

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
                { data: 'is_featured', name: 'is_featured', orderable: true },
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