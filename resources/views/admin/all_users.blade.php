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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">User
                        Management</a></li>
                <li class="breadcrumb-item" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">All User</li>
            </ol>
        </nav>
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
                                            <th>S no.</th>
                                            <th>Registration Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>User Role</th>
                                            {{-- <th> User Permission </th> --}}
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
                                                {{-- <td>{{ $allpermission }}</td> --}}
                                                <td class="action">
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
                                                    <div class="modal fade" id="myModal" tabindex="-1"
                                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div
                                                                            class="col-12 d-flex justify-content-between align-items-center">
                                                                            <h4 class="mt-4">Edit User Profile</h4>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row dashboard-header bg-light">
                                                                        <div class="col-md-12 mx-auto">
                                                                            <form
                                                                                class="notification-form shadow rounded p-3"
                                                                                action="{{ route('updateuserlist') }}"
                                                                                method="post" id="userFormData">
                                                                                @csrf
                                                                                <div class="form-group mb-3">
                                                                                    <label for="userName">User Name</label>
                                                                                    <input type="text" name="name"
                                                                                        value="{{ old('name') }}"
                                                                                        class="form-control" id="userName"
                                                                                        placeholder="please enter your name">
                                                                                    @if ($errors->has('name'))
                                                                                        <span
                                                                                            class="text-danger">{{ $errors->first('name') }}</span>
                                                                                    @endif
                                                                                </div>
                                                                                <input type="hidden" id="userId"
                                                                                    value="" name="userId">
                                                                                <div class="form-group mb-3">
                                                                                    <label for="userRole">Role</label>
                                                                                    <input type="text" name="role"
                                                                                        class="form-control" id="userRole"
                                                                                        placeholder="Role">
                                                                                    @if ($errors->has('role'))
                                                                                        <span
                                                                                            class="text-danger">{{ $errors->first('role') }}</span>
                                                                                    @endif
                                                                                </div>
                                                                                <h3>Assign Modules</h3>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-md-12 Modules d-flex flex-wrap justify-content-start">
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="all"
                                                                                                id="all"
                                                                                                name="permission[]" checked>
                                                                                            <label class="form-check-label"
                                                                                                for="all">All
                                                                                                User</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="usermanagement"
                                                                                                id="usermanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="usermanagement">User
                                                                                                Management</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="servicemanagement"
                                                                                                id="servicemanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="servicemanagement">Service
                                                                                                Management</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="professionalmanagement"
                                                                                                id="professionalmanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="professionalmanagement">Professional
                                                                                                Management</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="blogmanagement"
                                                                                                id="blogmanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="blogmanagement">Blog
                                                                                                Management</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="notifications"
                                                                                                id="notifications"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="notifications">Notification</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="customermanagement"
                                                                                                id="customermanagement"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="customermanagement">Customer
                                                                                                Management</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="booking"
                                                                                                id="booking"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="booking">Booking &
                                                                                                Scheduling</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="payment"
                                                                                                id="payment"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="payment">Payment &
                                                                                                Invoicing</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="feedback"
                                                                                                id="feedback"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="feedback">Feedback</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="complaint"
                                                                                                id="complaint"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="complaint">Complaint</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="referral"
                                                                                                id="referral"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="referral">Referral &
                                                                                                Earning</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="review"
                                                                                                id="review"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="review">Review &
                                                                                                Rating</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="reward"
                                                                                                id="reward"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="reward">Reward &
                                                                                                Commissions</label>
                                                                                        </div>
                                                                                        <div class="form-check me-3 mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                value="analytic"
                                                                                                id="analytic"
                                                                                                name="permission[]">
                                                                                            <label class="form-check-label"
                                                                                                for="analytic">Analytic &
                                                                                                Reporting</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit"
                                                                                    class="btn btn-dark btn-lg mt-3"
                                                                                    id="userUpdateButton">Update User
                                                                                    Profile</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#alluser").click(function() {
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.delete-location').click(function(event) {
                event.preventDefault();
                var userId = $(this).data('user-id');
                var row = $(this).closest('tr'); // Get the closest table row

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('delete-user') }}/" +
                                userId, // Using Laravel url() method
                            type: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'The user has been deleted.',
                                    'success'
                                );
                                table.row(row).remove()
                                    .draw(); // Remove the row from the DataTable
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the user: ' + error,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {});
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
    <script>
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}');
        @endif
    </script>
@endsection
