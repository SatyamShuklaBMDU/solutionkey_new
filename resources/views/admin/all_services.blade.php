@extends('include.master')

@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
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
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Category
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">All Category</li>
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
                    <div class="col-lg-12">
                        <div class="row" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('service-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('service') }}"
                                            style="background-color:#033496;font-size:15px;">Reset</a>
                                    </div>
                                    <div class="col-sm-3 text-end" style="margin-top: 40px;">
                                        <a class="btn btn-sm text-white" href="{{ route('service-create') }}"
                                            style="background-color:#033496;font-size:15px;">Create New Category</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body">
                                <table id="customerTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S No.</th>
                                            <th class="text-center">Image</th>
                                            {{-- <th class="text-center"> Date</th> --}}
                                            <th class="text-center">Name</th>
                                            {{-- <th class="text-center">Description</th> --}}
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr class="odd" data-user-id="{{ $service->id }}">
                                                <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                                @if ($service->image)
                                                    <td class="text-center"><a href="{{ asset($service->image) }}" target="_blank"
                                                            rel="noopener noreferrer"><img class="rounded"
                                                                src="{{ asset($service->image) }}" alt="Service Image"
                                                                style="width: 100px; height: 70px;"></a></td>
                                                @else
                                                    <td class="text-center">
                                                        <p>No image available</p>
                                                    </td>
                                                @endif
                                                {{-- <td class="text-center">{{ \Carbon\Carbon::parse($service->created_at)->format('d M,Y') }}</td> --}}
                                                <td class="text-center">{{ $service->services_name }}</td>
                                                {{-- <td class="text-center">{{ $service->description }}</td> --}}
                                                <td class="text-center">
                                                    @if ($service->status == 1)
                                                        <div class="job-status text-capitalize">Active</div>
                                                    @else
                                                        <div class="job-status text-capitalize">Block</div>
                                                    @endif
                                                </td>
                                                <td class="action text-center">
                                                    <button type="button" class="btn btn-outline-danger delete-service"
                                                        data-service-id="{{ $service->id }}">
                                                        <i class="fa fa-trash-o"
                                                            style="padding-right: -10px; font-size: 17px;"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-outline-danger">
                                                        <a href="{{ route('services-edit', encrypt($service->id)) }}">
                                                            <i class="fa fa-pencil"
                                                                style="padding-right: -10px;font-size: 17px;"></i>
                                                        </a>
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
        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceModalLabel">Create New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="serviceForm" action="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" id="service_id">
                            <div class="form-group">
                                <label for="services_name">Service Name</label>
                                <input type="text" name="services_name" class="form-control" id="services_name"
                                    aria-describedby="textHelp" placeholder="Please enter your service name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" class="form-control" id="description"
                                    aria-describedby="textHelp" placeholder="Please enter your description">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <button type="submit" class="btn btn-primary" id="submitServiceButton">Save changes</button>
                        </form>
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
            $('.delete-service').on('click', function() {
                var serviceId = $(this).data('service-id');
                var deleteUrl = `{{ url('delete-service') }}/${serviceId}`;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            },
                            success: function(data) {
                                console.log(data);
                                if (data.status == true) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The service has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred. Please try again.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('An error occurred:', status, error);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the service. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
