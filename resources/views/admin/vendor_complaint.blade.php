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
    </style>
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Complaint
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">Vendor Complaint</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                            <form action="{{ route('vendor-complaint-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1 text-end" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('vendor-complaint') }}"
                                            style="background-color:#033496;">Reset</a>
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
                                            <th>S No.</th>
                                            <th>Date</th>
                                            <th>Vendor Id</th>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Reply Date</th>
                                            <th>Reply</th>
                                            {{-- <th>Reply Btn</th> --}}
                                            <th>Action</th>
                                            {{-- <th>User Name</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($complaint as $user)
                                            <tr class="odd" data-user-id="{{ $user->id }}">
                                                <td class="sorting_1">{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M,Y') }}
                                                </td>
                                                <td>{{ $user->vendors->vendor_id ?? '' }}</td>
                                                <td>{{ $user->vendors->name ?? '' }}</td>
                                                <td>{{ $user->subject }}</td>
                                                <td>{{ $user->message }}</td>
                                                <td>
                                                    @if ($user->reply_date)
                                                        {{ $user->reply_date->timezone('Asia/Kolkata')->format('d F Y h:i A') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $user->reply }}</td>
                                                <td class="d-flex">
                                                    <div class="d-flex">
                                                        <a href="#"
                                                            class="btn btn-success shadow btn-1x sharp me-1 reply-btn"
                                                            data-complaint-id="{{ $user->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#basicModal">Reply
                                                        </a>
                                                    </div>
                                                    {{-- <div class="action">
                                                    <button type="button" class="btn btn-outline-danger">
                                                        <i class="fa fa-trash-o delete-location"
                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                    </button>  
                                                </div> --}}
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
    {{-- Modal Content --}}
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Reply Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form id="replyForm"action="{{ route('vendor-complaint-reply') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="complaintId" name="complaintId">
                        <div class="mb-3">
                            <label for="blogTitle" class="form-label text-dark fw-bold h5">Compose Response</label>
                            <input type="text" class="form-control border-dark" name='reply'id="replyMessage"
                                placeholder="Enter Compose Response" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="sendReply">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script-area')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const replyButtons = document.querySelectorAll('.reply-btn');
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const complaintId = this.getAttribute('data-complaint-id');
                    document.getElementById('complaintId').value = complaintId;
                });
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
            @if (session()->has('success'))
                toastr.success('{{ session('success') }}');
            @endif
        });
    </script>
@endsection
