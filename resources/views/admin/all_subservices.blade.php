@extends('include.master')
@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
            margin: 0px !important;
        }

        .breadcrumb {
            font-size: 18px !important;
            background-color: transparent;
            margin-bottom: 0;
            padding: 10px 0;
        }

        .notification-form {
            padding: 12px;
            margin: 14px 0px 40px 0px;
        }

        .Modules {
            flex-wrap: wrap;
        }

        .breadcrumb-item a {
            color: #333 !important;
        }

        .breadcrumb-item.active {
            color: #007bff !important;
        }

        .main_content .main_content_iner {
            margin: 0px !important;
        }

        #customerTable {
            font-size: 16px;
            /* Adjust the font size as needed */
        }

        .dt-button {
            background-color: #033496 !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-size: 14px;
            padding: 5px 10px;
            white-space: nowrap;
        }

        #customerTable_previous {
            transform: translateX(-20px);
        }

        /* For DataTable */
        #customerTable_wrapper,
        #customerTable th,
        #customerTable td {
            font-size: 15px;
        }

        /* For datepicker */
        .ui-datepicker {
            font-size: 15px;
        }

        /* For input placeholder */
        ::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            font-size: 15px;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            font-size: 15px;
        }

        :-ms-input-placeholder {
            /* IE 10+ */
            font-size: 15px;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            font-size: 15px;
        }

        #editModal {
            z-index: 1500;
            /* Adjust the value as needed */
        }
    </style>
    <style>
        #editModal {
            display: none;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Services
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">All Sub Services
                </li>
            </ol>
        </nav>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('service-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('service') }}"
                                            style="background-color:#033496;font-size:15px;">Reset</a>
                                    </div>
                                    <div class="col-sm-3 text-end" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('sub-service-create') }}"
                                            style="background-color:#0d9603;font-size:15px;">Create Sub Service</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Sub Services</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="editForm" action="{{ route('sub-services-update') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="row">
                                                @csrf
                                                <input type="hidden" id="service_id" name="service_id" />
                                                <div class="col-sm-12">
                                                    <label for="name">Name:</label>
                                                    <input type="text" id="name" name="name" class="form-control"
                                                        value="">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="description">Description:</label>
                                                    <textarea id="description" name="description" class="form-control"></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="services">Edit Services</label>
                                                    <select name="services" class="form-control" id="services">
                                                        <option selected disabled>Select Services</option>
                                                        @foreach ($allservice as $each)
                                                            <option value="{{ $each->id }}">{{ $each->services_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="service-image">Service Image</label>
                                                    <input type="file" class="form-control" name="image" />
                                                    <img src="" height="100px" width="100px" id="service-img" />
                                                </div>
                                                <!-- Add more fields here as needed -->
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body">
                                <table id="customerTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Services Name</th>
                                            <th>Sub Services Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr class="odd" data-user-id="{{ $service->id }}">
                                                <td class="sorting_1">{{ $loop->iteration }}</td>
                                                @if ($service->image)
                                                    <td><img class="rounded" src="{{ asset($service->image) }}"
                                                            alt="Service Image" style="width: 100px; height: 70px;"></td>
                                                @else
                                                    <td>
                                                        <p>No image available</p>
                                                    </td>
                                                @endif

                                                <td>{{ \Carbon\Carbon::parse($service->created_at)->format('d M,Y') }}
                                                </td>
                                                <td>{{ $service->services->services_name }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->description }}</td>
                                                <td>
                                                    @if ($service->status == 1)
                                                        <div class="job-status text-capitalize">Active</div>
                                                    @else
                                                        <div class="job-status text-capitalize">Block</div>
                                                    @endif
                                                </td>
                                                <td class="d-flex">
                                                    <form action="{{ route('delete-sub-service', $service->id) }}"
                                                        method="POST" id="delete-form-{{ $service->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-outline-danger delete-button">
                                                            <i class="fa fa-trash-o"
                                                                style="padding-right: -10px; font-size: 17px;"></i>
                                                        </button>
                                                    </form>
                                                    {{-- <button type="button" class="btn btn-outline-danger" data-service-id="{{ $service->id }}"> --}}
                                                    <button type="button" class="btn btn-outline-danger edit-button"
                                                        data-bs-toggle="modal" data-service-id="{{ $service->id }}"
                                                        data-bs-target="#exampleModal">
                                                        <i class="fa fa-pencil"
                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script-area')
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle delete button click
            $('.delete-button').click(function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formId = $(this).closest('form').attr('id');

                // Show confirmation dialog
                if (confirm("Are you sure you want to delete this service?")) {
                    // Submit the form
                    $('#' + formId).submit();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var baseUrl = "{{ url('/public') }}";
                var serviceId = $(this).data('service-id');
                var url = "{{ route('get-sub-service', ':id') }}";
                url = url.replace(':id', serviceId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#name').val(response.name);
                        $('#description').val(response.description);
                        $('#services').val(response.services_id);
                        $('#service-img').attr('src', baseUrl + '/' + response.image);
                        $('#service_id').val(serviceId);
                        $('#editModal').modal('show');
                    }
                });
            });

            // Close modal when close button is clicked
            $('#editModal').on('click', '[data-bs-dismiss="modal"]', function() {
                $('#editModal').modal('hide');
            });

            // Close modal when clicked outside the modal
            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal')) {
                    $('#editModal').modal('hide');
                }
            });
        });
    </script>
@endsection
