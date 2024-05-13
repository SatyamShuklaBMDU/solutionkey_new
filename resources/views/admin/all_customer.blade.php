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
                <li class="breadcrumb-item"><a href="#">Customer Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer Details</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                        <form action="{{ route('customer-filters') }}" method="post">
                                @csrf
                                @include('admin.date')
                                <div class="col-md-1 text-end" style="margin-left: 10px; margin-top: 47px;">
                                    <a class="btn text-white shadow-lg" href="{{ route('customer-shows') }}"
                                        style="background-color:#033496;">Reset</a>
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
                                                <th>Customer Profile</th>
                                                <th>Customer ID</th>
                                                <th>Name</th>
                                                <th>Phone number</th>
                                                <th>Email</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Martial Status</th>
                                                <th>Address</th>
                                                <th>City-State</th>
                                                <th>Action</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer as $customers)
                                                <tr data-customer-id="{{ $customers->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($customers->created_at)) }}</td>
                                                    <td><img src="{{ asset($customers->profile_pic) }}" width="100px" alt=""></td>
                                                    <td>{{ $customers->customers_id }}</td>
                                                    <td>{{ $customers->name }}</td>
                                                    <td>{{ $customers->phone_number }}</td>
                                                    <td>{{ $customers->email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($customers->dob)->format('d/m/Y') }}</td>
                                                    {{--<td>{{ $customers->dob }}</td>--}}
                                                    <td>{{ $customers->gender }}</td>
                                                    <td>{{ $customers->marital_status }}</td>
                                                    <td>{{ $customers->address }}</td>
                                                    <td>{{ $customers->city }}-{{ $customers->state }}</td>
                                                    <td>
                                                        <select class="form-control change-status-dropdown" data-customer-id="{{ $customers->id }}">
                                                            <option value="1" {{ $customers->account_status == 1 ? 'selected' : '' }}>Activate</option>
                                                            <option value="0" {{ $customers->account_status == 0 ? 'selected' : '' }}>Deactivate</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if ($customers->account_status == 0)
                                                        {{ $customers->deactivation_remark ?? '' }}
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
                var customerId = $(this).data('customer-id');
                var newStatus = $(this).val();
                var remark = '';
                if (newStatus == 0) {
                    remark = prompt("Please enter the reason for deactivation:", "");
                    if (remark === null) {
                        return;
                    }
                }
                $.ajax({
                    url: "{{ url('/change-customer-status') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        customer_id: customerId,
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
                var url = "{{ url('/delete-customer/:CustomerId') }}";
                url = url.replace(':CustomerId', CustomerId);
                if (confirm('Are you sure you want to delete this Number?')) {
                    $.ajax({
                        url: url,
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
