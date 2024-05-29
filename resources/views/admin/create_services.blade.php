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
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Category
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">Add Category</li>
            </ol>
        </nav>
        <div class="main_content_iner ">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="row dashboard-header" style="">
                    {{--  <div class="row">
                        <div class="main-header">
                            <h3 class="my-2 pl-4">Manage Services</h3>
                        </div>
                    </div>  --}}
                    <div class="col-md-11  mx-auto">
                        <form class="notification-form shadow rounded"
                            action="{{ isset($service) ? route('services-update', $service->id) : url('services-store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($service))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="services_name">Category Name</label>
                                <input type="text" name="services_name"
                                    value="{{ old('services_name', isset($service) ? $service->services_name : '') }}"
                                    class="form-control" id="services_name" aria-describedby="textHelp"
                                    placeholder="Please enter your service name" style="font-size: 15px;">
                                @error('services_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="discriptions">Description</label>
                                <input type="text" name="description"
                                    value="{{ old('description', isset($service) ? $service->description : '') }}"
                                    class="form-control" id="description" aria-describedby="textHelp"
                                    placeholder="Please enter your description" style="font-size: 15px;">
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (isset($service) && ($service->status === 1 || $service->status === 0))
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" style="font-size: 15px;">
                                        <option value="1"
                                            {{ old('status', $service->status) == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $service->status) == '0' ? 'selected' : '' }}>Block
                                        </option>
                                    </select>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control form-control-lg" id="image"
                                        style="font-size: 15px;" name="image">
                                </div>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (isset($service) && $service->image)
                                <div>
                                    <img src="{{ asset($service->image) }}" alt="Service Image"
                                        style="width: 200px; height: 150px;">
                                </div>
                            @endif
                            <button type="submit" class="btn btn-info text-danger text-bold shadow"
                                style="margin:30px 0px 0px;"><a href="{{ route('service') }}"
                                    style="text-decoration: none;color:white;font-weight:500">Back</a></button>
                            <button type="submit" class="btn btn-success"
                                style="margin:30px 0px 0px;font-weight:500;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript"></script>
