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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Noitification</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Add Notification
                </li>
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
                    <div class="col-md-11  mx-auto">
                        <form class="notification-form shadow rounded" method="post" style="background: #e5e5e5;"
                            action="{{ route('notification-store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Notification Send </label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('for') is-invalid @enderror" type="radio"
                                        style="font-size: 15px;" name="for" id="inlineRadio1" value="all"
                                        value="all" {{ old('for') == 'all' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio1">All</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('for') is-invalid @enderror" type="radio"
                                        style="font-size: 15px;" name="for" id="inlineRadio2" value="vendor"
                                        value="all" {{ old('for') == 'vendor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio2">For Vendor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('for') is-invalid @enderror" type="radio"
                                        style="font-size: 15px;" name="for" id="inlineRadio3" value="customer"
                                        value="all" {{ old('for') == 'customer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio3">For Customer</label>
                                </div>

                                @error('for')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" aria-describedby="textHelp" placeholder="Subject"
                                    style="font-size: 15px;" value="{{ old('subject') }}">
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

                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
