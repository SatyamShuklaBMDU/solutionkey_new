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
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Noitification Management</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Add Notification</li>
            </ol>
        </nav>
        <div class="main_content_iner ">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="row dashboard-header">
                    <div class="row">
                        <div class="main-header">
                            <h3 class="my-2 pl-4">Manage Notifications</h3>
                        </div>
                    </div>
                    <div class="col-md-11  mx-auto">
                        <form class="notification-form shadow rounded" method="post" style="background: #e5e5e5;"
                            action="{{ route('notification-store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Notification Send </label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('for') is-invalid @enderror" type="radio" style="font-size: 15px;"
                                        name="for" id="inlineRadio1" value="all" value="all"
                                        {{ old('for') == 'all' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio1">All</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('for') is-invalid @enderror" type="radio" style="font-size: 15px;"
                                        name="for" id="inlineRadio2" value="vendor" value="all"
                                        {{ old('for') == 'vendor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio2">For Vendor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('for') is-invalid @enderror" type="radio" style="font-size: 15px;"
                                        name="for" id="inlineRadio3" value="customer" value="all"
                                        {{ old('for') == 'customer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio3">For Customer</label>
                                </div>

                                @error('for')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" aria-describedby="textHelp" placeholder="Subject" style="font-size: 15px;"
                                    value="{{ old('subject') }}">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Notification Message</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Type Message" name="message"
                                    id="exampleFormControlTextarea1" rows="3"> {{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- jQuery Validation plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

<!-- headr-file-start -->

<script>
    function resetFunction() {
        $("input[type=radio]").prop('checked', false);
    }
</script>
<script>
    $(document).ready(function() {
        var tableNotifications = $('#notifications').DataTable({
            scrollX: true,
        });
    });

    function filterDatas(element) {
        var filterVal = element.value;
        var tbody = document.querySelector('#filterDataTable tbody');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'get',
            url: "{{ url('filter_notification') }}",
            data: {
                filterVal: filterVal
            },
            success: function(data) {
                if (data.status == "success") {
                    $('#notifications').closest('.dataTables_wrapper').hide();
                    tbody.innerHTML = '';
                    $('#filterDataTable').show();
                    let filterLength = data.notifications.length;
                    for (let i = 0; i < filterLength; i++) {
                        var htmls = "<tr>";
                        htmls += "<td>" + (i + 1) + "</td>";
                        htmls += "<td>" + data.notifications[i].for+"</td>";
                        var createdAt = new Date(data.notifications[i].created_at);
                        var date = createdAt.toLocaleDateString();
                        htmls += "<td>" + date + "</td>";
                        htmls += "<td>" + data.notifications[i].subject + "</td>";
                        htmls += "<td>" + data.notifications[i].message + "</td>";
                        htmls += "</tr>";
                        $("#filterDataTable tbody").append(htmls);
                    }
                    if ($.fn.DataTable.isDataTable('#filterDataTable')) {
                        $('#filterDataTable').DataTable().destroy();
                    }
                    $('#filterDataTable').DataTable({
                        scrollX: true,
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
<script>
    var currentDate = new Date().toISOString().split('T')[0];
    document.getElementById('enddate').setAttribute('max', currentDate);
    document.getElementById('startdate').setAttribute('max', currentDate);
</script>
@include('include.footer')
