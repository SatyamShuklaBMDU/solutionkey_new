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
    </style>
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Feedback
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">Users Feedback</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                            <form action="{{ route('feedback-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1 text-end" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('feedback') }}"
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
                                            <th> Date</th>
                                            <th>Customer Id</th>
                                            <th>Customer Name</th>
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
                                        @foreach ($feedback as $user)
                                            <tr class="odd" data-user-id="{{ $user->id }}">
                                                <td class="sorting_1">{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M,Y') }}</td>
                                                <td>{{ $user->customer->customers_id ?? '' }}</td>
                                                <td>{{ $user->customer->name ?? '' }}</td>
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
                                                            class="btn btn-success shadow sharp me-1 reply-btn"
                                                            data-feedback-id="{{ $user->id }}" data-bs-toggle="modal"
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
                    <h5 class="modal-title h2">Reply Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form id="replyForm"action="{{ route('feedback-reply') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="feedbackId" name="feedbackId">
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
                    // alert(1);
                    const feedbackId = this.getAttribute('data-feedback-id');
                    // alert(feedbackId);
                    document.getElementById('feedbackId').value = feedbackId;
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.delete-location').click(function(event) {
                event.preventDefault();
                var CustomerId = $(this).closest('tr').attr('data-user-id');
                alert(CustomerId);
                if (confirm('Are you sure you want to delete this?')) {
                    $.ajax({
                        url: '{{ url('/delete-feedback/') }}' + '/' + CustomerId,
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
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}');
        @endif
    </script>
@endsection
