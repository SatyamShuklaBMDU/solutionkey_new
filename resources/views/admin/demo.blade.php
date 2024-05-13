@extends('include.master')
@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
        }
    </style>
@endsection
@section('content-area')
    {{-- section content --}}

    <section class="main_content dashboard_part">
        <div class="main_content_iner ">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        {{-- content start  --}}
                        <div class="main_content_iner">
                            <div class="container-fluid plr_30 body_white_bg pt_30">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 ">
                                        <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                                            <form action="{{ route('service-filter') }}" method="post">
                                                @csrf
                                                <div class="col-sm-1">
                                                    <p class="text-dark">
                                                        <b>
                                                            <strong>Filters:</strong>
                                                        </b>
                                                    </p>
                                                </div>
                                                <div class="col-sm-3 end-date">
                                                    <p class="text-dark">
                                                        <strong>Date From:</strong>
                                                    </p>
                                                    <div class="input-group date d-flex">
                                                        <input type="date" class="form-control" name="start" id="datepickerFrom"
                                                            value="{{ $start ?? '' }}" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 end-date">
                                                    <p class="text-dark">
                                                        <strong>Date To:</strong>
                                                    </p>
                                                    <div class="input-group date d-flex">
                                                        <input type="date" class="form-control" name="end" id="datepickerTo"
                                                            value="{{ $end ?? '' }}" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </div>
                                                <div class="col-md-1 text-end" style="margin-left: 10px; margin-top: 47px;">
                                                    <button class="btn text-white shadow-lg" type="submit"
                                                        style="background-color:#033496;">Filter</button>
                                                </div>
                                                <div class="col-md-1 text-end" style="margin-left: 10px; margin-top: 47px;">
                                                    <a class="btn text-white shadow-lg" href="{{ route('service') }}"
                                                        style="background-color:#033496;">Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Table -->
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="customerTable" class="display nowrap" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S No.</th>
                                                            <th> Date</th>
                                                            <th>Reward Type</th>
                                                            <th>Reward Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reward_commissions as $service)
                                                            <tr class="odd" data-user-id="{{ $service->id }}">
                                                                <td class="sorting_1">{{ $loop->iteration }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($service->created_at)->format('d M,Y') }}
                                                                </td>
                                                                <td>{{ $service->reward_type }}</td>
                                                                <td>{{ $service->reward_amount }}</td>
                                                
                                                                <td class="action">
                                                                    <button type="button" class="btn btn-outline-danger">
                                                                        <i class="fa fa-trash-o delete-location" data-service-id="{{ $service->id }}"
                                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-danger">
                                                                        <a href="{{ route('services-edit', $service->id) }}">
                                                                            <i class="fa fa-pencil"
                                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                                        </a>
                                                                    </button>
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
                        {{-- content start end  --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- section content end --}}
@endsection