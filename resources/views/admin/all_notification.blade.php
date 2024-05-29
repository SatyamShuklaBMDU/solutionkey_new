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
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Notifications</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">All Notification</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <div class="col-sm-9">
                                <form action="{{ route('notification-filter') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        @include('admin.date')
                                        <div class="col-sm-1" style="margin-top: 40px;">
                                            <a class="btn text-white shadow-lg" href="{{ route('notification') }}"
                                                style="background-color:#033496;font-size:15px;">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-3" style="margin-top: 40px;">
                                <a class="btn text-white shadow-lg" style="background-color:#033496;font-size:15px;" href="{{ route('notification-create') }}" role="button">Add
                                    Notification</a>
                            </div>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body">
                                <table id="customerTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S No.</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">For</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Subject</th>
                                            <th class="text-center">Message</th>
                                        </tr>
                                    </thead>

                                    </thead>
                                    <tbody>
                                        @foreach ($notification as $notification)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($notification->created_at)->format('d M,Y') }}</td>
                                                <td class="text-center">{{ $notification->for }}</td>
                                                <td class="text-center">{{ $notification->created_at->format('d/m/y') }}</td>
                                                <td class="text-center">{{ $notification->subject }}</td>
                                                <td class="text-center">{{ $notification->message }}</td>
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
