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
                <li class="breadcrumb-item"><a href="#">Reward & Commission Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Reward & Commission</li>
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
                <div class="row dashboard-header" style="background: #e5e5e5;">
                    <div class="row">
                        <div class="main-header">
                            <h3 class="my-2 pl-4">Manage Reward & Commission</h3>
                        </div>
                    </div>
                    <div class="col-md-6  mx-auto">
                        <form class="notification-form shadow rounded"
                            action="{{ isset($reward) ? route('reward-update', $reward->id) : route('reward-store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($reward))
                                @method('PUT')
                            @endif
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
                            <div class="form-group">
                                <label for="reward_amount">Reward Amounts</label>
                                <input type="number" name="reward_amount"
                                    value="{{ old('reward_amount', isset($reward) ? $reward->reward_amount : '') }}"
                                    class="form-control" id="reward_amount" aria-describedby="textHelp"
                                    placeholder="Please enter your Reward Amount">
                                @error('reward_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info text-danger   text-bold shadow btn-lg " style="margin:30px 0px 0px;"><a href="{{ route('reward-commission') }}">Back</a></button>
                            <button type="submit" class="btn btn-dark btn-lg" style="margin:30px 0px 0px;">Submit</button>
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
