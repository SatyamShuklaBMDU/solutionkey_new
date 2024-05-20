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
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">User Management</a></li>
                <li class="breadcrumb-item" aria-current="page" style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">All User</li>
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
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;font-size:15px;">
                            <form action="{{ route('user-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                @include('admin.date')
                                <div class="col-sm-1 text-end" style="margin-top: 40px;font-size:15px;">
                                    <a class="btn text-white shadow-lg" href="{{ route('all-users') }}"
                                        style="background-color:#033496;font-size:15px;">Reset</a>
                                </div>
                                </div>
                            </form>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body table-responsive">
                                <table id="customerTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                S no.</th>
                                            <th>
                                                Registration Date
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th> Email</th>
                                            <th> User Role </th>
                                            <th> User Permission </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="odd" data-user-id="{{ $user->id }}">
                                                <td class="">{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M,Y') }}
                                                </td>
                                                <td class="sorting_1">{{ $user->name }} </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role }}</td>
                                                @php
                                                    $userpermission = json_decode($user->permission);
                                                    $allpermission = '';
                                                    if (!is_null($userpermission) && is_array($userpermission)) {
                                                        $allpermission = implode(',', $userpermission);
                                                    }
                                                @endphp
                                                <td>{{ $allpermission }}</td>
                                                <td class="action">
                                                    {{-- <button type="button" class="btn btn-outline-danger">
                                                        <i class="fa fa-trash-o delete-location"
                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                    </button> --}}
                                                    <button type="button" class="btn btn-outline-danger">
                                                        <i class="fa fa-trash-o delete-location"
                                                            data-user-id="{{ $user->id }}"
                                                            style="padding-right: -10px; font-size: 17px;"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        onclick="showModal(this)" id="{{ $user->id }}">
                                                        <i class="fa fa-pencil"
                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                    </button>
                                                    <div class="modal" id="myModal">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="main-header">
                                                                            <h4 class="mt-4">Edit User Profile</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row dashboard-header"
                                                                        style="background: #e5e5e5;">
                                                                        <div class="col-md-12 mx-auto">
                                                                            <form class="notification-form shadow rounded"
                                                                                action="{{ route('updateuserlist') }}"
                                                                                method="post" id="userFormData">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">User
                                                                                        Name</label>
                                                                                    <input type="text" name="name"
                                                                                        value="{{ old('name') }}"
                                                                                        class="form-control" id="userName"
                                                                                        aria-describedby="textHelp"
                                                                                        placeholder="please enter your name">
                                                                                    @if ($errors->has('name'))
                                                                                        <span
                                                                                            class="help-block">{{ $errors->first('name') }}</span>
                                                                                    @endif
                                                                                </div>
                                                                                <input type="hidden" id="userId"
                                                                                    value="" name="userId">
                                                                                <div class="form-group">
                                                                                    <label for="userRole">Role</label>
                                                                                    <input type="text" name="role"
                                                                                        class="form-control" id="userRole"
                                                                                        aria-describedby="textHelp"
                                                                                        placeholder="Role">
                                                                                    @if ($errors->has('role'))
                                                                                        <span
                                                                                            class="help-block">{{ $errors->first('role') }}</span>
                                                                                    @endif
                                                                                </div>
                                                                                <h3>Assign Modules</h3>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-md-12 Modules d-flex justify-content-around">
                                                                                        <div class="form-check"
                                                                                            style="">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="all"
                                                                                                id="all"
                                                                                                name="permission[]"
                                                                                                checked>
                                                                                            <label class="form-check-label"
                                                                                                for="all">
                                                                                                All User
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check"
                                                                                            style="">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="usermanagement"
                                                                                                id="usermanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="usermanagement">
                                                                                                User Management
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check"
                                                                                            style="">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="servicemanagement"
                                                                                                id="servicemanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="servicemanagement">
                                                                                                Service Management
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="professionalmanagement"
                                                                                                id="professionalmanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="professionalmanagement">
                                                                                                Professional Management
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="blogmanagement"
                                                                                                id="blogmanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="blogmanagement">
                                                                                                Blog Management
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="notifications"
                                                                                                id="notifications"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="notifications">
                                                                                                Notification
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-12 Modules d-flex justify-content-around ">
                                                                                        <div class="form-check ">
                                                                                            <input
                                                                                                class="form-check-input "
                                                                                                type="checkbox"
                                                                                                value="customermanagement"
                                                                                                id="customermanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="customermanagement">
                                                                                                Customer Management
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="booking"
                                                                                                id="booking"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="booking">
                                                                                                Booking & Scheduling
                                                                                            </label>
                                                                                        </div>
                                                                                        <!-- <div class="col-md-4"> -->
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="payment"
                                                                                                id="payment"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="payment">
                                                                                                Payment & Invoicing
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-12 Modules d-flex justify-content-around">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="feedback"
                                                                                                id="feedback"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="feedback">
                                                                                                Feedback
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="complaint"
                                                                                                id="complaint"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="complaint">
                                                                                                Complaint
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="referral"
                                                                                                id="referral"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="referral">
                                                                                                Referral & Earning
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="review"
                                                                                                id="review"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="review">
                                                                                                Review & Rating
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="reward"
                                                                                                id="reward"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="reward">
                                                                                                Reward & Commissions
                                                                                            </label>
                                                                                        </div>
                                                                                        <!-- <div class="col-md-4"> -->
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="analytic"
                                                                                                id="analytic"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="analytic">
                                                                                                Analytic & Reporting
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit"
                                                                                    class="btn btn-dark btn-lg"
                                                                                    style="margin: 30px 0px 0px;"
                                                                                    id="userUpdateButton">Update User
                                                                                    Profile
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                var userId = $(this).data('user-id');
                if (confirm('Are you sure you want to delete this Number?')) {
                    $.ajax({
                        url: '/delete-user/' + userId,
                        type: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Deleted successfully');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('Error deleting Number: ' + error);
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
    <script>
        function showModal(button) {
            var userId = button.id;
            $("input[type='checkbox']:checked").prop("checked", false);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: "{{ url('edit-users') }}",
                data: {
                    id: userId
                },
                success: function(data) {
                    console.log(data);
                    $('#userName').val(data.name);
                    $('#userRole').val(data.role);
                    $('#userId').val(data.id);
                    $('input[type="checkbox"]').prop("checked", false);
                    // console.log(data.permission);
                    var permissionArray = JSON.parse(data.permission);
                    if (Array.isArray(permissionArray)) {
                        permissionArray.forEach(function(permission) {
                            console.log("Checking checkbox with ID:", permission);
                            $("#" + permission).prop("checked", true);
                        });
                    } else {
                        console.error("Permission data is not an array or is missing.");
                    }

                    $('#myModal').modal('show');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        };
    </script>
@endsection
