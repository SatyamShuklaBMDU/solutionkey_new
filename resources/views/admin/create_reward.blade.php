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
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Reward &
                        Commission </a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">Add Reward & Commission</li>
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
                <div class="row dashboard-header">
                    <div class="col-md-11  mx-auto">
                        <form class="notification-form shadow rounded"
                            action="{{route('reward-store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="reward_type">Reward Type</label>
                                <input type="text" name="reward_type"
                                    value="{{ old('reward_type', isset($reward) ? $reward->reward_type : '') }}"
                                    class="form-control" id="reward_type" aria-describedby="textHelp"
                                    placeholder="Please enter your reward name" style="text-transform: capitalize;">
                                @error('reward_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="reward_amount">Reward Amounts</label>
                                <input type="number" name="reward_amount"
                                    value="{{ old('reward_amount', isset($reward) ? $reward->reward_amount : '') }}"
                                    class="form-control" id="reward_amount" aria-describedby="textHelp"
                                    placeholder="Please enter your Reward Amount">
                                @error('reward_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <a class="btn btn-info shadow-lg" style="text-decoration: none;color:white;margin:30px 0px 0px;" href="{{ route('reward-commission') }}">Back</a>
                            <button type="submit" class="btn btn-dark shadow-lg" style="margin:30px 0px 0px;">Submit</button>
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
