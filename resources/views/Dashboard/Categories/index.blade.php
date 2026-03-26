@extends('layouts.dashboard.dashboard')

@section('title', 'All Categories')

<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">

<style>
    #myTable_wrapper {
        padding: 0 0 2rem;
    }

    .dt-input {
        margin-right: 5px;
    }
</style>

@section('content')
    <!-- ########## START: RIGHT PANEL ########## -->
    <div class="sl-sideright">
        <ul class="nav nav-tabs nav-fill sidebar-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" role="tab" href="#messages">Messages (2)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" role="tab" href="#notifications">Notifications (8)</a>
            </li>
        </ul><!-- sidebar-tabs -->

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane pos-absolute a-0 mg-t-60 active" id="messages" role="tabpanel">
                <div class="media-list">
                    <!-- loop starts here -->
                    <a href="" class="media-list-link">
                        <div class="media">
                            <img src="{{ asset('assets/dashboard/img/img3.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Donna Seay</p>
                                <span class="d-block tx-11 tx-gray-500">2 minutes ago</span>
                                <p class="tx-13 mg-t-10 mg-b-0">A wonderful serenity has taken possession of my entire soul,
                                    like these
                                    sweet mornings of spring.</p>
                            </div>
                        </div><!-- media -->
                    </a>
                    <!-- loop ends here -->
                    <a href="" class="media-list-link">
                        <div class="media">
                            <img src="{{ asset('assets/dashboard/img/img4.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Samantha Francis</p>
                                <span class="d-block tx-11 tx-gray-500">3 hours ago</span>
                                <p class="tx-13 mg-t-10 mg-b-0">My entire soul, like these sweet mornings of spring.</p>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link">
                        <div class="media">
                            <img src="{{ asset('assets/dashboard/img/img7.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Robert Walker</p>
                                <span class="d-block tx-11 tx-gray-500">5 hours ago</span>
                                <p class="tx-13 mg-t-10 mg-b-0">I should be incapable of drawing a single stroke at the
                                    present
                                    moment...</p>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link">
                        <div class="media">
                            <img src="{{ asset('assets/dashboard/img/img5.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Larry Smith</p>
                                <span class="d-block tx-11 tx-gray-500">Yesterday, 8:34pm</span>

                                <p class="tx-13 mg-t-10 mg-b-0">When, while the lovely valley teems with vapour around me,
                                    and the
                                    meridian sun strikes...</p>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link">
                        <div class="media">
                            <img src="{{ asset('assets/dashboard/img/img3.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Donna Seay</p>
                                <span class="d-block tx-11 tx-gray-500">Jan 23, 2:32am</span>
                                <p class="tx-13 mg-t-10 mg-b-0">A wonderful serenity has taken possession of my entire soul,
                                    like these
                                    sweet mornings of spring.</p>
                            </div>
                        </div><!-- media -->
                    </a>
                </div><!-- media-list -->
                <div class="pd-15">
                    <a href=""
                        class="btn btn-secondary btn-block bd-0 rounded-0 tx-10 tx-uppercase tx-mont tx-medium tx-spacing-2">View
                        More Messages</a>
                </div>
            </div><!-- #messages -->

            <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto" id="notifications" role="tabpanel">
                <div class="media-list">
                    <!-- loop starts here -->
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img8.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Suzzeth
                                        Bungaos</strong>
                                    tagged you and 18 others in a post.</p>
                                <span class="tx-12">October 03, 2017 8:45am</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <!-- loop ends here -->
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img9.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Mellisa
                                        Brown</strong>
                                    appreciated your work <strong class="tx-medium tx-gray-800">The Social Network</strong>
                                </p>
                                <span class="tx-12">October 02, 2017 12:44am</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img10.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700">20+ new items added are for sale in your <strong
                                        class="tx-medium tx-gray-800">Sale Group</strong></p>
                                <span class="tx-12">October 01, 2017 10:20pm</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img5.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Julius
                                        Erving</strong> wants
                                    to connect with you on your conversation with <strong
                                        class="tx-medium tx-gray-800">Ronnie
                                        Mara</strong></p>
                                <span class="tx-12">October 01, 2017 6:08pm</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img8.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Suzzeth
                                        Bungaos</strong>
                                    tagged you and 12 others in a post.</p>
                                <span class="tx-12">September 27, 2017 6:45am</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img10.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700">10+ new items added are for sale in your <strong
                                        class="tx-medium tx-gray-800">Sale Group</strong></p>
                                <span class="tx-12">September 28, 2017 11:30pm</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img9.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Mellisa
                                        Brown</strong>
                                    appreciated your work <strong class="tx-medium tx-gray-800">The Great Pyramid</strong>
                                </p>
                                <span class="tx-12">September 26, 2017 11:01am</span>
                            </div>
                        </div><!-- media -->
                    </a>
                    <a href="" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img src="{{ asset('assets/dashboard/img/img5.jpg') }}" class="wd-40 rounded-circle" alt="">
                            <div class="media-body">
                                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Julius
                                        Erving</strong> wants
                                    to connect with you on your conversation with <strong
                                        class="tx-medium tx-gray-800">Ronnie
                                        Mara</strong></p>
                                <span class="tx-12">September 23, 2017 9:19pm</span>
                            </div>
                        </div><!-- media -->
                    </a>
                </div><!-- media-list -->
            </div><!-- #notifications -->

        </div><!-- tab-content -->
    </div>
    <!-- sl-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('home') }}">OneTech</a>
            <span class="breadcrumb-item active">Dashboard</span>
        </nav>


        <div class="sl-pagebody m-4">

            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-4">
                Add New Category
            </a>

            <table id="myTable" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-left">Category Name</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($categories as $category)
                        <tr>
                            <td class="align-content-center">{{ $category->name }}</td>
                            <td class="text-center  align-content-center">{{ $category->order }}</td>
                            <td class="text-center">
                                <button class="btn btn-info edit-category" data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}" style="cursor:pointer">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger delete-category" data-id="{{ $category->id }}"
                                    style="cursor: pointer;">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div><!-- sl-pagebody -->
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
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection


@section('js')

    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>;
    <script>let table = new DataTable('#myTable');</script>;

    {{-- Update --}}

    <script>
        $(document).ready(function () {
            $('.edit-category').on('click', function (e) {
                e.preventDefault();

                let id = $(this).data('id');
                let name = $(this).data('name');

                Swal.fire({
                    title: "Enter New Category Name",
                    input: "text",
                    inputValue: name,
                    showCancelButton: true,
                    confirmButtonText: "Update",
                    showLoaderOnConfirm: true,

                    preConfirm: (newName) => {
                        return fetch(`/categories/${id}`, {
                            method: "PUT",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({ name: newName })
                        })
                            .then(async response => {

                                const data = await response.json();

                                if (!response.ok) {

                                    if (data.errors) {
                                        let messages = Object.values(data.errors)
                                            .flat()
                                            .join('<br>');

                                        Swal.showValidationMessage(messages);
                                    } else {
                                        Swal.showValidationMessage(data.message || 'Update failed');
                                    }

                                    return false;
                                }

                                return data;
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Error: ${error}`);
                            });
                    }
                })
                    .then((result) => {

                        if (result.isConfirmed && result.value) {

                            Swal.fire(
                                'Success',
                                'Category updated successfully',
                                'success'
                            ).then(() => {
                                location.reload();
                            });

                        }

                    });

            });
        });
    </script>

    {{-- {{ Delete }} --}}
    <script>
        $(document).ready(function () {
            $('.delete-category').on('click', function (e) {
                e.preventDefault();
                let id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Category will be deleted !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/categories/${id}`, {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                        })
                            .then(async response => {
                                if (!response.ok) {
                                    const data = await response.json();
                                    throw new Error(data.message || "Delete failed!");
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire(
                                    'Deleted!',
                                    'Category has been deleted.',
                                    'success'
                                ).then(() => location.reload());
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error!',
                                    error.message,
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>
@endsection