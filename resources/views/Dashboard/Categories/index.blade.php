@extends('layouts.dashboard.dashboard')

@section('title', 'All Categories')


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
            <span class="breadcrumb-item active">Categories</span>
        </nav>

        <div class=" sl-pagebody m-4">

            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-4" z>
                Add New Category
            </a>

            <table id="myTable" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-left">Category Name</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Action</th>
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


    {{-- Update --}}
    <script>
        $(document).on('click', '.edit-category', function (e) {

            e.preventDefault();

            let id = $(this).data('id');
            let name = $(this).data('name');
            let order = $(this).data('order');

            Swal.fire({
                title: 'Edit Category',

                html: `
                                                            <input id="swal-name"
                                                                class="swal2-input"
                                                                placeholder="Category Name"
                                                                value="${name}">

                                                            <input id="swal-order"
                                                                type="number"
                                                                class="swal2-input"
                                                                placeholder="Order"
                                                                value="${order}">
                                                        `,

                showCancelButton: true,
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,

                preConfirm: () => {

                    const newName =
                        document.getElementById('swal-name').value;

                    const newOrder =
                        document.getElementById('swal-order').value;

                    return fetch(`/categories/${id}`, {

                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content
                        },

                        body: JSON.stringify({
                            _method: 'PUT',
                            name: newName,
                            order: newOrder
                        })
                    })
                        .then(async response => {

                            const data = await response.json();

                            if (!response.ok) {

                                let messages = Object
                                    .values(data.errors || {})
                                    .flat()
                                    .join('<br>');

                                Swal.showValidationMessage(
                                    messages
                                );

                                return false;
                            }

                            return data;
                        });
                }
            })
                .then(result => {

                    if (result.isConfirmed) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated Successfully',
                            timer: 1500,
                            showConfirmButton: false
                        })
                            .then(() => location.reload());
                    }
                });
        });
    </script>

    {{-- {{ Delete }} --}}
    <script>

        $(document).on('click', '.delete-category', function (e) {
            e.preventDefault();

            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch(`/categories/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        // body: JSON.stringify({ _method: "DELETE" })
                    })
                        .then(res => res.json())
                        .then(() => {
                            Swal.fire('Deleted!', '', 'success')
                                .then(() => location.reload());
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'Something went wrong', 'error');
                        });

                }
            });
        });

    </script>





    {{-- Datatables Show Data --}}
    <script>
        let table = new DataTable('#myTable', {
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories.index') }}",
            order: [[2, 'asc']],    //ترتيب العمود التاني  تصاعدي 
            columns: [
                { data: 'name', name: 'name', orderable: true },
                { data: 'order', name: 'order', orderable: true },
                { data: 'image', name: 'image', orderable: true },
                { data: 'action', name: 'action', orderable: false, searchable: true }
            ]
        });
    </script>
@endsection