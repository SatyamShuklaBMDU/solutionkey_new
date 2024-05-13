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
         #customerTable_wrapper, #customerTable th, #customerTable td {
            font-size: 15px;
        }

        /* For datepicker */
        .ui-datepicker {
            font-size: 15px;
        }
        /* For input placeholder */
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            font-size: 15px;
        }
        ::-moz-placeholder { /* Firefox 19+ */
            font-size: 15px;
        }
        :-ms-input-placeholder { /* IE 10+ */
            font-size: 15px;
        }
        :-moz-placeholder { /* Firefox 18- */
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
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Document Management</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">All Documents</li>
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
                        <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                            <form action="{{ route('document-filter') }}" method="post">
                                @csrf
                                @include('admin.date')
                                <div class="col-md-1 text-end" style="margin-left: 10px; margin-top: 47px;">
                                    <a class="btn text-white shadow-lg" href="{{ route('customer-document') }}"
                                        style="background-color:#033496;font-size:15px;">Reset</a>
                                </div>
                            </form>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body">
                                <table id="customerTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th> Date</th>
                                            <th>Customer Id</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Document Description</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_documents as $document)
                                            <tr class="odd" data-user-id="{{ $document->id }}">
                                                <td class="sorting_1">{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($document->created_at)->format('d M,Y') }} </td>
                                                <td>{{ $document->customer->customers_id}}</td>
                                                <td>{{ $document->customer->name }}</td>
                                                @if ($document->documents_images)
                                                    <td><img class="rounded" src="{{ asset($document->documents_images) }}" alt="No Image" style="width: 100px; height: 70px;"></td>
                                                @else
                                                   <td><p>No image available</p></td>
                                                @endif
                                                <td>{{ $document->document_description }}</td>
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
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#alluser").click(function() {
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.delete-location').click(function(event) {
                event.preventDefault();
                var serviceId = $(this).data('service-id');
                if (confirm('Are you sure you want to delete this service?')) {
                    $.ajax({
                        url: 'delete-service/'+ serviceId,
                        type: 'DELETE',
                        data: { id: serviceId },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Service deleted successfully');
                            location.reload(); // Reload the page after deletion
                        },
                        error: function(xhr, status, error) {
                            alert('Error deleting service: ' + error);
                        }
                    });
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
        $(function() {
            $('#datepickerFrom').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

            $('#datepickerTo').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });
        });
    </script>
@endsection
