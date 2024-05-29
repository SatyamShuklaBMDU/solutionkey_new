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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Blog
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Approved Blog</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('blog-approve-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1 text-end" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('blog-approved') }}"
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
                                                <th class="text-center">Posting Date</th>
                                                <th class="text-center">CIN No</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Number</th>
                                                <th class="text-center">Blog Image</th>
                                                <th class="text-center">Blog Title</th>
                                                <th class="text-center">Blog Content</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($blog as $blogs)
                                                <tr data-blog-id="{{ $blogs->id }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">
                                                        {{ date('d-m-Y', strtotime($blogs->created_at)) }}</td>
                                                    <td class="text-center">{{ $blogs->vendor->vendor_id }}</td>
                                                    <td class="text-center">{{ $blogs->vendor->name }}</td>
                                                    <td class="text-center">{{ $blogs->vendor->phone_number }}</td>
                                                    <td class="text-center"><a href="{{ asset($blogs->blog_media) }}"
                                                            target="_blank" rel="noopener noreferrer"><img
                                                                src="{{ asset($blogs->blog_media) }}" width="50px"
                                                                height="50px" alt=""></a></td>
                                                    <td class="text-center">{{ $blogs->title }}</td>
                                                    <td class="text-center">{{ $blogs->content }}</td>
                                                    <td class="text-center text-success">Approved</td>
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
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
