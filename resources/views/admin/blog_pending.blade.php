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
    </style>
@endsection

@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Blog
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Pending Blog</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('blog-pending-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1 text-end" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('blog-pending') }}"
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
                                                <th class="text-center">S no.</th>
                                                <th class="text-center">Media</th>
                                                <th class="text-center">Posting Date</th>
                                                <th class="text-center">Person Id</th>
                                                <th class="text-center">Person</th>
                                                <th class="text-center">Content</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($blog as $blogs)
                                                <tr data-blog-id="{{ $blogs->id }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center"><a href="{{ asset($blogs->blog_media) }}" target="_blank"
                                                            rel="noopener noreferrer"><img
                                                                src="{{ asset($blogs->blog_media) }}" width="50px"
                                                                height="50px" alt=""></a></td>
                                                    <td class="text-center">{{ date('d-m-Y', strtotime($blogs->created_at)) }}</td>
                                                    <td class="text-center">{{ $blogs->vendor->vendor_id }}</td>
                                                    <td class="text-center">{{ $blogs->vendor->name }}</td>
                                                    <td class="text-center">{{ $blogs->content }}</td>
                                                    <td class="text-center">
                                                        <select class="form-select change-status-dropdown"
                                                            data-blog-id="{{ $blogs->id }}" style="font-size: 15px;">
                                                            <option value="" selected disabled>Choose</option>
                                                            <option value="-1"
                                                                {{ $blogs->status == -1 ? 'selected' : '' }}>Reject
                                                            </option>
                                                            <option value="1"
                                                                {{ $blogs->status == 1 ? 'selected' : '' }}>Approve
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($blogs->status == -1)
                                                            {{ $blogs->status_remark ?? '' }}
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.change-status-dropdown').change(function() {
                var blogID = $(this).data('blog-id');
                var newStatus = $(this).val();

                if (newStatus == -1) {
                    Swal.fire({
                        title: 'Reject Blog',
                        input: 'text',
                        inputLabel: 'Please enter the reason for Rejection:',
                        inputPlaceholder: 'Enter your reason here...',
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var remark = result.value;
                            $.ajax({
                                url: "{{ route('change.blog.status') }}",
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    blog_id: blogID,
                                    new_status: newStatus,
                                    remark: remark,
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Account status Changed',
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while changing the status.',
                                    });
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ route('change.blog.status') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            blog_id: blogID,
                            new_status: newStatus,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Account status Changed',
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while changing the status.',
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-location').click(function(event) {
                event.preventDefault();
                var CustomerId = $(this).closest('tr').attr('data-customer-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this Number?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/delete-customer/' + CustomerId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Number has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the Number.',
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
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
