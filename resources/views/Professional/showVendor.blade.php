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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Professional Management</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Vendor Details</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                            <form action="{{ route('vendor-filter') }}" method="post">
                                @csrf
                               @include('admin.date')
                                <div class="col-md-1 text-end" style="margin-left: 10px; margin-top: 47px;">
                                    <a class="btn text-white shadow-lg" href="{{ route('vendor-show') }}"
                                        style="background-color:#033496;font-size:15px;">Reset</a>
                                </div>
                            </form>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="customerTable" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S no.</th>
                                                <th>Registration Date</th>
                                                <th>Vendor Image</th>
                                                <th>Vendor Cover</th>
                                                <th>Vendor Id</th>
                                                <th>Name</th>
                                                <th>Whatsapp number</th>
                                                <th>Email</th>
                                                <th>Area of Interest</th>
                                                <th>Designation</th>
                                                <th>Highest Qualification</th>
                                                <th>Experience</th>
                                                <th>Current Job</th>
                                                <th>Adhar Number</th>
                                                <th>Pan Number</th>
                                                <th>Action</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vendor as $vendors)
                                                <tr data-vendor-id="{{ $vendors->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($vendors->created_at)) }}</td>
                                                    <td><img src="{{ asset($vendors->profile_picture) }}" width="100px" height="100px" alt=""></td>
                                                    <td><img src="{{ asset($vendors->cover_picture) }}" width="100px" height="100px" alt=""></td>
                                                    <td>{{ $vendors->vendor_id }}</td>
                                                    <td>{{ $vendors->name }}</td>
                                                    <td>{{ $vendors->whatsapp_number }}</td>
                                                    <td>{{ $vendors->email }}</td>
                                                    <td>{{ $vendors->area_of_interest }}</td>
                                                    <td>{{ $vendors->designation }}</td>
                                                    <td>{{ $vendors->highest_qualification }}</td>
                                                    <td>{{ $vendors->experience }}</td>
                                                    <td>{{ $vendors->current_job }}</td>
                                                    <td>{{ $vendors->adhar_number }}</td>
                                                    <td>{{ $vendors->pancard }}</td>
                                                    <td>
                                                        <select class="form-control change-status-dropdown" data-vendor-id="{{ $vendors->id }}" style="font-size: 15px;min-width:130%;">
                                                            <option value="1" {{ $vendors->account_status == 1 ? 'selected' : '' }}>Activate</option>
                                                            <option value="0" {{ $vendors->account_status == 0 ? 'selected' : '' }}>Deactivate</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if ($vendors->account_status == 0)
                                                            {{ $vendors->deactivation_remark ?? '' }}
                                                        @else
                                                            --
                                                        @endif
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
        </div>
    </section>
@endsection
@section('script-area')
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.change-status-dropdown').change(function() {
                var VendorID = $(this).data('vendor-id');
                var newStatus = $(this).val();
                var remark = '';
                if (newStatus == 0) {
                    remark = prompt("Please enter the reason for deactivation:", "");
                    if (remark === null) {
                        return;
                    }
                }
                $.ajax({
                    url: "{{ route('change.vendor.account.status') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        vendor_id: VendorID,
                        new_status: newStatus,
                        remark: remark,
                    },
                    success: function(response) {
                        alert('Account status Changed');
                        location.reload();
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.delete-location').click(function(event) {
                event.preventDefault();
                var CustomerId = $(this).closest('tr').attr('data-customer-id');
                if (confirm('Are you sure you want to delete this Number?')) {
                    $.ajax({
                        url: '/delete-customer/' + CustomerId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Deleted successfully');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('Error deleting Number:', error);
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
