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
            <a class="breadcrumb-item" href="#">Dashboard</a>
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
        $(document).on('click', '.edit-category', function () {

            let id = $(this).data('id');
            let name = $(this).data('name');
            let order = $(this).data('order');

            Swal.fire({

                title: 'Update Category',

                html: `
                                                <input id="swal-name"
                                                    class="swal2-input"
                                                    value="${name}">

                                                <input id="swal-order"
                                                    class="swal2-input"
                                                    value="${order}">

                                                <input id="swal-image"
                                                    type="file"
                                                    class="swal2-file"
                                                    accept=".jpg,.jpeg,.png,.webp">
                                            `,

                showCancelButton: true,

                preConfirm: () => {

                    let formData = new FormData();

                    formData.append('name', $('#swal-name').val());
                    formData.append('order', $('#swal-order').val());
                    formData.append('_method', 'PUT');

                    let image = document.getElementById('swal-image').files[0];

                    if (image) {
                        formData.append('image', image);
                    }

                    return $.ajax({
                        url: `/categories/${id}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN':
                                $('meta[name="csrf-token"]').attr('content')
                        }
                    }).catch(function (xhr) {

                        let errors = xhr.responseJSON?.errors;

                        let message = '';

                        if (errors) {
                            message = Object.values(errors)
                                .flat()
                                .join('<br>');
                        } else {
                            message = 'Something went wrong';
                        }

                        Swal.showValidationMessage(message);
                    });
                }

            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire(
                        'Success',
                        'Category Updated',
                        'success'
                    ).then(() => {
                        $('#myTable')
                            .DataTable()
                            .ajax.reload(null, false);
                    });
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
            order: [[1, 'asc']],    //ترتيب العمود التاني  تصاعدي 
            columns: [
                { data: 'name', name: 'name', orderable: true },
                { data: 'order', name: 'order', orderable: true },
                { data: 'image', name: 'image', orderable: true },
                { data: 'action', name: 'action', orderable: false, searchable: true }
            ]
        });
    </script>
@endsection