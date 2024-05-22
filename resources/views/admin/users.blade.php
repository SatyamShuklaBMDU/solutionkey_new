@extends('include.master')
@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
            font-size: 16px !important;
        }
    </style>
    <style>
        .notification-form {
            padding: 40px;
            margin: 40px 0px 40px 0px;
        }

        .sidebar-right-trigger {
            display: none;
        }

        .Modules {
            flex-wrap: wrap;
        }

        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
    </style>
@endsection
@section('content-area')
    {{-- section content --}}
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603;font-weight:600;font-size:20px;">User Management</a></li>
                <li class="breadcrumb-item" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">Add User</li>
            </ol>
        </nav>
        <div class="main_content_iner ">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="row dashboard-header" style="">
                    <div class="col-md-11  mx-auto">
                        <form class="notification-form shadow rounded" action="{{ route('users-store') }}" method="post">
                            <div class="form-group mb-2">
                                <label for="exampleInputEmail1">User Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    style="font-size: 15px;" id="exampleInputsubject" placeholder="please enter your name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                    style="font-size: 15px;" id="exampleInputsubject" aria-describedby="textHelp"
                                    placeholder="Please enter your email">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            @csrf
                            <div class="form-group mb-2">
                                <label for="exampleInputEmail1">Create Password</label>
                                <input type="password" name="password" class="form-control" id="password-field"
                                    style="font-size: 15px;" aria-describedby="textHelp" placeholder="*****">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="exampleInputEmail1">Role</label>
                                <input type="text" name="role" class="form-control" id="exampleInputsubject"
                                    style="font-size: 15px;" aria-describedby="textHelp" placeholder="Role">
                                @if ($errors->has('role'))
                                    <span class="text-danger">{{ $errors->first('role') }}</span>
                                @endif
                            </div>
                            <h4>Assign Modules</h4>
                            <div class="col-md-12  Modules d-flex justify-content-around">
                                <div class="form-check" style="">
                                    <input class="form-check-input" type="checkbox" value="all" id="all"
                                        name="permission[]">
                                    <label class="form-check-label" for="all">
                                        All User
                                    </label>
                                </div>
                                <div class="form-check" style="">
                                    <input class="form-check-input" type="checkbox" value="usermanagement"
                                        id="usermanagement" name="permission[]">
                                    <label class="form-check-label" for="usermanagement">
                                        User Management
                                    </label>
                                </div>
                                <div class="form-check" style="">
                                    <input class="form-check-input" type="checkbox" value="servicemanagement"
                                        id="servicemanagement" name="permission[]">
                                    <label class="form-check-label" for="servicemanagement">
                                        Service Management
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="professionalmanagement"
                                        id="professionalmanagement" name="permission[]">
                                    <label class="form-check-label" for="professionalmanagement">
                                        Professional Management
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="blogmanagement"
                                        id="blogmanagement" name="permission[]">
                                    <label class="form-check-label" for="blogmanagement">
                                        Blog Management
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-around ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="notifications"
                                        id="notifications" name="permission[]">
                                    <label class="form-check-label" for="notifications">
                                        Notification
                                    </label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input " type="checkbox" value="customermanagement"
                                        id="customermanagement" name="permission[]">
                                    <label class="form-check-label" for="customermanagement">
                                        Customer Management
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="booking" id="booking"
                                        name="permission[]">
                                    <label class="form-check-label" for="booking">
                                        Booking & Scheduling
                                    </label>
                                </div>
                                <!-- <div class="col-md-4"> -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="payment" id="payment"
                                        name="permission[]">
                                    <label class="form-check-label" for="payment">
                                        Payment & Invoicing
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feedback" id="feedback"
                                        name="permission[]">
                                    <label class="form-check-label" for="feedback">
                                        Feedback
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-around">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="complaint" id="complaint"
                                        name="permission[]">
                                    <label class="form-check-label" for="complaint">
                                        Complaint
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="referral" id="referral"
                                        name="permission[]">
                                    <label class="form-check-label" for="referral">
                                        Referral & Earning
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="review" id="review"
                                        name="permission[]">
                                    <label class="form-check-label" for="review">
                                        Review & Rating
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="reward" id="reward"
                                        name="permission[]">
                                    <label class="form-check-label" for="reward">
                                        Reward & Commissions
                                    </label>
                                </div>
                                <!-- <div class="col-md-4"> -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="analytic" id="analytic"
                                        name="permission[]">
                                    <label class="form-check-label" for="analytic">
                                        Analytic & Reporting
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Assign Roles</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script type="text/javascript">
    $(document).ready(function() {
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        if ($("#all").is(":checked")) {
            $("input[type=checkbox]").prop('checked', true);
        }
        $("#all").click(function() {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    });
</script>
