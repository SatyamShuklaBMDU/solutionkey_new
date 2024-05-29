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
            font-size: 15px;
        }

        ::-moz-placeholder {
            font-size: 15px;
        }

        :-ms-input-placeholder {
            font-size: 15px;
        }

        :-moz-placeholder {
            font-size: 15px;
        }
    </style>
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Online Booking
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">All Booking Online
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
                    <div class="col-lg-12">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('online-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('online-booking') }}"
                                            style="background-color:#033496;font-size:15px;">Reset</a>
                                    </div>
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
                                                <th class="text-center">S No.</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Customer Id</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Vendor Id</th>
                                                <th class="text-center">Vendor Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schedule_slots as $online_booking)
                                                <tr class="odd text-center" data-user-id="{{ $online_booking->id }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">
                                                        {{ \Carbon\Carbon::parse($online_booking->created_at)->format('d M,Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $online_booking->customer->customers_id ?? '--' }}</td>
                                                    <td class="text-center">{{ $online_booking->customer->name }}</td>
                                                    <td class="text-center">{{ $online_booking->vendor->vendor_id ?? '--' }}
                                                    </td>
                                                    <td class="text-center">{{ $online_booking->vendor->name }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm view-details"
                                                            data-bs-toggle="modal" data-bs-target="#detailsModal"
                                                            data-date="{{ \Carbon\Carbon::parse($online_booking->created_at)->format('d M,Y') }}"
                                                            data-perferred_date_1="{{ \Carbon\Carbon::parse($online_booking->date)->format('d M, Y') }} {{ \Carbon\Carbon::parse($online_booking->perferred_time_1)->format('h:i A') }}"
                                                            data-perferred_date_2="{{ $online_booking->preferred_time_2 ? \Carbon\Carbon::parse($online_booking->date . ' ' . $online_booking->preferred_time_2)->format('d M, Y h:i A') : '--' }}"
                                                            data-communication_mode="{{ $online_booking->communication_mode }}"
                                                            data-status="{{ ucfirst($online_booking->status) }}">
                                                            <i class="fa fa-eye text-dark"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailsModalLabel">Booking Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Date:</strong> <span id="modalDate"></span></p>
                                        <p><strong>Preferred Date 1:</strong> <span id="modalPerferredDate1"></span></p>
                                        <p><strong>Preferred Date 2:</strong> <span id="modalPerferredDate2"></span></p>
                                        <p><strong>Communication Mode:</strong> <span id="modalCommunicationMode"></span>
                                        </p>
                                        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
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

        $('#detailsModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var date = button.data('date');
            var perferred_date_1 = button.data('perferred_date_1');
            var perferred_date_2 = button.data('perferred_date_2');
            var communication_mode = button.data('communication_mode');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#modalDate').text(date);
            modal.find('#modalPerferredDate1').text(perferred_date_1);
            modal.find('#modalPerferredDate2').text(perferred_date_2);
            modal.find('#modalCommunicationMode').text(communication_mode);
            modal.find('#modalStatus').text(status);
        });
    </script>
@endsection
